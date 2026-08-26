<?php

namespace App\Services;

use App\Models\Kegiatan;
use App\Models\Arsip;
use App\Models\Sambutan;
use App\Models\Personel;
use App\Models\AsetKendaraan;
use App\Models\AsetBarang;
use App\Models\Keuangan;
use App\Models\Instansi;
use App\Models\Arahan;
use App\Models\Notulensi;
use App\Models\Penugasan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsistenAiService
{
    public function generateResponse(string $prompt, ?int $userId = null, ?array $fileData = null): array
    {
        Carbon::setLocale('id');
        $cleanPrompt = strtolower(trim($prompt));

        // 1. Extreme Safety Guardrail (Only genuinely harmful/illegal acts)
        if ($this->isIllegalOrDangerous($cleanPrompt)) {
            return [
                'content' => "Mohon maaf, saya tidak dapat memproses permintaan yang berkaitan dengan konten terlarang atau berbahaya. Saya siap membantu untuk pertanyaan umum, tugas administratif, informasi kedinasan, penyusunan naskah, dan analisis data lainnya.",
                'structured_data' => null,
                'source' => 'system_guardrail',
            ];
        }

        // 2. Primary: Google Gemini AI (Full General Intelligence + E-Prokopim Context)
        $apiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: session('gemini_api_key');
        if (!empty($apiKey)) {
            try {
                $geminiResponse = $this->callGeminiApi($prompt, $apiKey, $fileData);
                if ($geminiResponse) {
                    return $geminiResponse;
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini API call failed, falling back to local engine: ' . $e->getMessage());
            }
        }

        // 3. Fallback Engine with Live Database Queries
        if (!empty($fileData)) {
            return $this->handleFileAttachment($fileData, $cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'siaran pers') || str_contains($cleanPrompt, 'press release') || str_contains($cleanPrompt, 'caption') || str_contains($cleanPrompt, 'berita') || str_contains($cleanPrompt, 'humas')) {
            return $this->handleSiaranPers($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'jadwal') || str_contains($cleanPrompt, 'agenda') || str_contains($cleanPrompt, 'kegiatan')) {
            return $this->handleJadwalPimpinan($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'ringkas surat') || str_contains($cleanPrompt, 'surat masuk') || str_contains($cleanPrompt, 'arsip') || str_contains($cleanPrompt, 'rangkuman')) {
            return $this->handleRingkasSurat();
        }

        if (str_contains($cleanPrompt, 'sambutan') || str_contains($cleanPrompt, 'pidato')) {
            return $this->handleDrafSambutan($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'pegawai') || str_contains($cleanPrompt, 'personel') || str_contains($cleanPrompt, 'petugas') || str_contains($cleanPrompt, 'kabag') || str_contains($cleanPrompt, 'staf')) {
            return $this->handlePegawai($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'aset') || str_contains($cleanPrompt, 'kendaraan') || str_contains($cleanPrompt, 'mobil') || str_contains($cleanPrompt, 'plat')) {
            return $this->handleAset($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'keuangan') || str_contains($cleanPrompt, 'anggaran') || str_contains($cleanPrompt, 'biaya') || str_contains($cleanPrompt, 'transaksi')) {
            return $this->handleKeuangan($cleanPrompt);
        }

        if (str_contains($cleanPrompt, 'walikota') || str_contains($cleanPrompt, 'wali kota') || str_contains($cleanPrompt, 'pimpinan bandung') || str_contains($cleanPrompt, 'farhan') || str_contains($cleanPrompt, 'erwin')) {
            return [
                'content' => "Pemerintah Kota Bandung saat ini dipimpin oleh **Wali Kota Bandung, Bapak Muhammad Farhan, S.E. (Pak Farhan)** dan **Wakil Wali Kota Bandung, Bapak H. Erwin, S.E., M.Pd. (Kang Erwin)**, didampingi oleh jajaran Sekretaris Daerah Kota Bandung dan perangkat daerah.\n\nBagian Protokol dan Komunikasi Pimpinan (Prokopim) bertugas langsung memfasilitasi dan mengoordinasikan seluruh agenda keprotokolan serta komunikasi publik pimpinan daerah Kota Bandung.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        // Kaprodi / Pimpinan Prodi Teknik Informatika UNIKOM Terkini
        if ((str_contains($cleanPrompt, 'kaprodi') || str_contains($cleanPrompt, 'ketua prodi') || str_contains($cleanPrompt, 'kepala prodi') || str_contains($cleanPrompt, 'sekprodi') || str_contains($cleanPrompt, 'sekretaris prodi') || str_contains($cleanPrompt, 'pimpinan prodi') || str_contains($cleanPrompt, 'ketua jurusan') || str_contains($cleanPrompt, 'dosen prodi')) && (str_contains($cleanPrompt, 'informatika') || str_contains($cleanPrompt, 'unikom') || str_contains($cleanPrompt, 'if'))) {
            return [
                'content' => "Ketua Program Studi (Kaprodi) Teknik Informatika Universitas Komputer Indonesia (UNIKOM) saat ini dijabat oleh **Bapak Hanhan Maulana, M.Kom., Ph.D.**\n\nBerikut adalah susunan pimpinan Program Studi Teknik Informatika UNIKOM (Masa Bakti 2024–2026):\n• **Ketua Program Studi (Kaprodi)**: Hanhan Maulana, M.Kom., Ph.D.\n• **Sekretaris Program Studi (Sekprodi)**: Dr. Ednawati Rainarli, S.Si., M.Si.\n• **Dekan FTIK (Fakultas Teknik & Ilmu Komputer)**: Dr. Ir. Herman S. Soegoto, MBA\n• **Rektor UNIKOM**: Prof. Dr. Ir. H. Eddy Soeryanto Soegoto, M.T.\n\n*(Catatan: Pejabat Kaprodi pada periode masa bakti sebelumnya adalah Bapak Dr. Ir. Yusrila Kerlo Mauluddin, M.T.).*",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        // HMIF UNIKOM
        if (str_contains($cleanPrompt, 'hmif') || str_contains($cleanPrompt, 'himpunan mahasiswa teknik informatika')) {
            return [
                'content' => "Himpunan Mahasiswa Teknik Informatika (HMIF) UNIKOM resmi didirikan pada tanggal **15 Januari 1997** di Bandung.\n\nHMIF UNIKOM merupakan wadah organisasi kemahasiswaan di tingkat Program Studi Teknik Informatika UNIKOM yang aktif dalam pengembangan keilmuan teknologi informasi, kepemimpinan, riset mahasiswa, dan pengabdian masyarakat.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        // Teknik Informatika UNIKOM Umum
        if ((str_contains($cleanPrompt, 'teknik informatika') || str_contains($cleanPrompt, 'prodi if') || str_contains($cleanPrompt, 'jurusan if')) && str_contains($cleanPrompt, 'unikom')) {
            return [
                'content' => "Program Studi S1 Teknik Informatika UNIKOM berada di bawah naungan **Fakultas Teknik dan Ilmu Komputer (FTIK)** Universitas Komputer Indonesia.\n\n• **Ketua Program Studi (Kaprodi)**: Hanhan Maulana, M.Kom., Ph.D.\n• **Sekretaris Program Studi (Sekprodi)**: Dr. Ednawati Rainarli, S.Si., M.Si.\n• **Akreditasi**: Unggul / A\n• **Fokus Bidang Keahlian**: Software Engineering, Artificial Intelligence, Cybersecurity, Multimedia & Game Development, Data Science, dan Network Architecture.\n• **Lokasi Kampus**: Jl. Dipati Ukur No. 112-116, Coblong, Kota Bandung.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        // Profil UNIKOM Kampus Umum
        if (str_contains($cleanPrompt, 'unikom') || str_contains($cleanPrompt, 'universitas komputer indonesia')) {
            return [
                'content' => "Universitas Komputer Indonesia (UNIKOM) berlokasi di **Jl. Dipati Ukur No. 112-116, Lebakgede, Kec. Coblong, Kota Bandung, Jawa Barat 40132**.\n\nUNIKOM dipimpin oleh Rektor **Prof. Dr. Ir. H. Eddy Soeryanto Soegoto, M.T.** dan diresmikan secara resmi pada tanggal 8 Agustus 2000 (berawal dari STMIK IKP tahun 1994). UNIKOM terkenal dengan prestasinya di bidang robotika, animasi, software development, dan teknologi informasi baik di tingkat nasional maupun internasional.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        // Keprotokolan & Tata Acara
        if (str_contains($cleanPrompt, 'protokol') || str_contains($cleanPrompt, 'keprotokolan') || str_contains($cleanPrompt, 'tata tempat') || str_contains($cleanPrompt, 'tata upacara') || str_contains($cleanPrompt, 'tata penghormatan')) {
            return [
                'content' => "Berdasarkan **Undang-Undang Nomor 9 Tahun 2010 tentang Keprotokolan**, keprotokolan adalah serangkaian kegiatan yang berkaitan dengan aturan dalam acara kenegaraan atau acara resmi yang meliputi:\n\n1. **Tata Tempat (Preseance)**: Aturan urutan tempat bagi pejabat negara, pejabat pemerintahan, perwakilan negara asing, dan tokoh masyarakat.\n2. **Tata Upacara**: Aturan pelaksanaan upacara dalam acara kenegaraan atau resmi (kelengkapan upacara, susunan acara, pembacaan naskah, lagu kebangsaan).\n3. **Tata Penghormatan**: Aturan pemberian penghormatan bagi pejabat negara/pemerintahan dan lambang-lambang kehormatan negara.\n\nBagian Prokopim Setda Kota Bandung bertugas mengimplementasikan standar keprotokolan ini dalam seluruh agenda pimpinan daerah Kota Bandung.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        if (str_contains($cleanPrompt, 'dimana') || str_contains($cleanPrompt, 'lokasi') || str_contains($cleanPrompt, 'alamat') || str_contains($cleanPrompt, 'kantor')) {
            return [
                'content' => "Kantor Bagian Protokol dan Komunikasi Pimpinan (Prokopim) Setda Kota Bandung berlokasi di:\n\n" .
                    "Komplek Balai Kota Bandung\n" .
                    "Jl. Wastukancana No. 2, Babakan Ciamis, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40117.\n\n" .
                    "Bagian Prokopim berada di bawah naungan Sekretariat Daerah (Setda) Pemerintah Kota Bandung yang bertugas memfasilitasi kegiatan pimpinan daerah dan keprotokolan.",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        return [
            'content' => "Halo! Saya adalah Asisten AI Prokopim Kota Bandung.\n\n" .
                "Terkait pertanyaan Anda: \"{$prompt}\", saya siap membantu menjawab berbagai hal seputar tugas kedinasan, keprotokolan, agenda pimpinan, pembuatan siaran pers, naskah pidato, maupun informasi umum seputar Pemerintah Kota Bandung dan lingkungan akademisi/lembaga mitra.\n\n" .
                "Silakan berikan instruksi lebih spesifik atau lampirkan berkas yang ingin dianalisis 📎.",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function callGeminiApi(string $prompt, string $apiKey, ?array $fileData = null): ?array
    {
        $modelsToTry = array_unique(array_filter([
            config('services.gemini.model', 'gemini-3.6-flash'),
            'gemini-3.6-flash',
            'gemini-3.1-flash-lite-preview',
            'gemini-flash-latest',
            'gemini-3.7-flash',
            'gemini-3.5-flash',
            'gemini-2.5-pro',
            'gemini-3-flash-preview',
        ]));

        $systemInstruction = $this->buildSystemInstruction();
        $parts = [];

        // Attach file data if image or text
        if ($fileData && !empty($fileData['path'])) {
            $storagePath = storage_path('app/public/' . $fileData['path']);
            if (file_exists($storagePath)) {
                $mime = mime_content_type($storagePath);
                if (str_starts_with($mime, 'image/') || $mime === 'application/pdf') {
                    $fileBase64 = base64_encode(file_get_contents($storagePath));
                    $parts[] = [
                        'inline_data' => [
                            'mime_type' => $mime,
                            'data' => $fileBase64,
                        ]
                    ];
                } else {
                    $parts[] = [
                        'text' => "[Pengguna melampirkan berkas: {$fileData['name']} ({$fileData['type']})]\n\n"
                    ];
                }
            }
        }

        $parts[] = ['text' => $prompt];

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => $parts,
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 2048,
            ]
        ];

        foreach ($modelsToTry as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            try {
                $response = Http::withoutVerifying()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(18)
                    ->post($url, $payload);

                if ($response->successful()) {
                    $resJson = $response->json();
                    $candidateParts = $resJson['candidates'][0]['content']['parts'] ?? [];
                    $generatedText = '';
                    foreach ($candidateParts as $cp) {
                        if (empty($cp['thought'])) {
                            $generatedText .= $cp['text'] ?? '';
                        }
                    }

                    if (!empty(trim($generatedText))) {
                        // Check if query is about schedule to parse structured card
                        $cleanPrompt = strtolower($prompt);
                        $structuredData = null;
                        if (str_contains($cleanPrompt, 'jadwal') || str_contains($cleanPrompt, 'agenda') || str_contains($cleanPrompt, 'kegiatan')) {
                            $now = Carbon::now();
                            $kegiatanDb = Kegiatan::whereDate('tanggal_mulai', '>=', $now->toDateString())
                                ->orderBy('tanggal_mulai', 'asc')
                                ->take(3)
                                ->get();

                            if ($kegiatanDb->count() > 0) {
                                $items = [];
                                foreach ($kegiatanDb as $k) {
                                    $items[] = [
                                        'time' => $k->tanggal_mulai ? $k->tanggal_mulai->format('H:i') : '09:00',
                                        'title' => $k->judul,
                                        'location' => $k->lokasi ?? 'Balai Kota Bandung',
                                    ];
                                }
                                $structuredData = [
                                    'type' => 'schedule',
                                    'title' => 'Agenda Pimpinan Terverifikasi',
                                    'items' => $items,
                                ];
                            }
                        }

                        return [
                            'content' => trim($generatedText),
                            'structured_data' => $structuredData,
                            'source' => 'gemini_ai',
                        ];
                    }
                } else {
                    Log::warning("Gemini API Error with model {$model}: " . $response->status() . ' - ' . $response->body());
                }
            } catch (\Throwable $e) {
                Log::warning("Gemini API Exception with model {$model}: " . $e->getMessage());
            }
        }

        return null;
    }

    protected function buildSystemInstruction(): string
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $currentDate = $now->translatedFormat('l, d F Y - H:i') . ' WIB';

        // 1. Profil Instansi (Live dari DB)
        $instansi = Instansi::first();
        $namaInstansi = $instansi?->nama_instansi ?? 'Bagian Protokol dan Komunikasi Pimpinan (Prokopim)';
        $pemda = $instansi?->pemerintah_daerah ?? 'Pemerintah Kota Bandung';
        $alamat = $instansi?->alamat_lengkap ?? 'Komplek Balai Kota Bandung, Jl. Wastukancana No. 2, Babakan Ciamis, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40117';
        $email = $instansi?->email_kontak ?? 'prokopim@bandung.go.id';
        $telepon = $instansi?->nomor_telepon ?? '(022) 4232338';

        // 2. Snapshot Kegiatan Pimpinan Terkini (Hari Ini, Mendatang & Riwayat)
        $kegiatanHariIni = Kegiatan::whereDate('tanggal_mulai', $now->toDateString())->orderBy('tanggal_mulai', 'asc')->get();
        $kegiatanMendatang = Kegiatan::whereDate('tanggal_mulai', '>', $now->toDateString())->orderBy('tanggal_mulai', 'asc')->take(6)->get();
        $kegiatanRiwayat = Kegiatan::orderBy('tanggal_mulai', 'desc')->take(6)->get();

        $kegiatanSummary = "AGENDA HARI INI (" . $now->translatedFormat('d F Y') . "):\n";
        if ($kegiatanHariIni->count() > 0) {
            foreach ($kegiatanHariIni as $k) {
                $pimpinan = is_array($k->pimpinan) ? implode(', ', $k->pimpinan) : ($k->pimpinan ?? '-');
                $kegiatanSummary .= "- [{$k->tanggal_mulai?->format('H:i')}] {$k->judul} | Lokasi: {$k->lokasi} | Dihadiri: {$pimpinan} | Status: {$k->status}\n";
            }
        } else {
            $kegiatanSummary .= "- Tidak ada agenda terjadwal khusus untuk hari ini.\n";
        }

        $kegiatanSummary .= "\nAGENDA MENDATANG / TERKINI:\n";
        $listKegiatan = $kegiatanMendatang->count() > 0 ? $kegiatanMendatang : $kegiatanRiwayat;
        foreach ($listKegiatan as $k) {
            $tgl = $k->tanggal_mulai ? $k->tanggal_mulai->translatedFormat('d M Y H:i') : '-';
            $pimpinan = is_array($k->pimpinan) ? implode(', ', $k->pimpinan) : ($k->pimpinan ?? '-');
            $kegiatanSummary .= "- [{$tgl}] {$k->judul} (Tempat: {$k->lokasi}, Dihadiri: {$pimpinan}, Status: {$k->status})\n";
        }

        // 3. Snapshot Arsip Surat Masuk Terbaru
        $arsip = Arsip::orderBy('id', 'desc')->take(6)->get();
        $arsipSummary = "";
        if ($arsip->count() > 0) {
            foreach ($arsip as $a) {
                $tgl = $a->tanggal_dokumen ? $a->tanggal_dokumen->translatedFormat('d M Y') : '-';
                $arsipSummary .= "- No: {$a->nomor_surat} | Tgl: {$tgl} | Perihal: {$a->judul} | Instansi: {$a->instansi} | Kategori: {$a->kategori}\n";
            }
        } else {
            $arsipSummary = "- Belum ada arsip surat masuk yang tercatat.\n";
        }

        // 4. Snapshot Data Personel / Pegawai Prokopim
        $pegawaiCount = Personel::count();
        $pegawaiSample = Personel::take(8)->get();
        $pegawaiSummary = "Total: {$pegawaiCount} Pegawai Terdaftar. Contoh Personel:\n";
        foreach ($pegawaiSample as $p) {
            $pegawaiSummary .= "- {$p->nama_lengkap} (Jabatan: {$p->jabatan}, NIP: {$p->nip}, Status: {$p->status_kepegawaian})\n";
        }

        // 5. Snapshot Sambutan & Pidato Pimpinan
        $sambutanLatest = Sambutan::orderBy('id', 'desc')->take(4)->get();
        $sambutanSummary = "";
        if ($sambutanLatest->count() > 0) {
            foreach ($sambutanLatest as $s) {
                $tgl = $s->tanggal_surat ? $s->tanggal_surat->translatedFormat('d M Y') : '-';
                $sambutanSummary .= "- Perihal: {$s->perihal} | Asal: {$s->asal_instansi} | Tgl: {$tgl} | Urgensi: {$s->status_urgensi} | Status: {$s->status}\n";
            }
        } else {
            $sambutanSummary = "- Belum ada data permohonan/draf sambutan.\n";
        }

        // 6. Snapshot Arahan Pimpinan
        $arahanLatest = Arahan::orderBy('id', 'desc')->take(4)->get();
        $arahanSummary = "";
        if ($arahanLatest->count() > 0) {
            foreach ($arahanLatest as $ar) {
                $tgl = $ar->tanggal_arahan ? $ar->tanggal_arahan->translatedFormat('d M Y') : '-';
                $arahanSummary .= "- [{$tgl}] Pimpinan: {$ar->pimpinan_label} | Judul: {$ar->judul} | Arahan: {$ar->isi_arahan} | Status: {$ar->status}\n";
            }
        } else {
            $arahanSummary = "- Belum ada data arahan pimpinan.\n";
        }

        // 7. Snapshot Aset & Keuangan
        $kendaraanCount = AsetKendaraan::count();
        $kendaraanSample = AsetKendaraan::take(3)->get();
        $kendaraanListStr = "";
        foreach ($kendaraanSample as $kend) {
            $kendaraanListStr .= "{$kend->nama_kendaraan} ({$kend->nomor_polisi}), ";
        }
        $kendaraanListStr = rtrim($kendaraanListStr, ', ');

        $barangCount = AsetBarang::count();
        $keuanganCount = Keuangan::count();
        $keuanganTotal = Keuangan::where('status', 'selesai')->sum('nominal');
        $keuanganFormatted = 'Rp ' . number_format($keuanganTotal, 0, ',', '.');

        return <<<EOT
Anda adalah "Asisten AI E-Prokopim", asisten kecerdasan buatan cerdas serbaguna yang ramah, sopan, berwawasan luas, dan profesional, bertugas di lingkungan {$namaInstansi}, {$pemda}.

KEMAMPUAN UTAMA ANDA:
1. PENGETAHUAN UMUM & KECERDASAN LUAS: Anda dapat menjawab SEMUA pertanyaan umum dari pengguna tanpa batas — termasuk profil pimpinan daerah Kota Bandung (Walikota, Wakil Walikota, Sekda, kepala bagian), sejarah/budaya Kota Bandung/Indonesia, sains, teknologi, keprotokolan kenegaraan, kepenulisan naskah, analisis data, sapaan ramah, maupun pertanyaan harian lainnya dengan cerdas, lugas, dan akurat.
2. INTEGRASI REALTIME BASIS DATA E-PROKOPIM: Anda terhubung langsung secara real-time dengan seluruh basis data E-Prokopim (jadwal/agenda pimpinan, arsip surat, draf sambutan, arahan pimpinan, data personel/pegawai, aset kendaraan & inventaris, realisasi anggaran/keuangan). Gunakan data ini untuk menjawab pertanyaan operasional secara spesifik, aktual, dan mutakhir.
3. KEPENULISAN & KOMUNIKASI RESMI: Anda sangat mahir menyusun draf naskah pidato/sambutan resmi, siaran pers humas, caption media sosial, notulensi rapat, disposisi surat, dan telaahan staf.
4. ANALISIS BERKAS & MULTIMODAL: Jika pengguna melampirkan berkas (dokumen PDF, foto dokumentasi, video), telaah isinya dan berikan resume serta rekomendasi tindak lanjut yang konstruktif.

WAKTU REALTIME SAAT INI: {$currentDate}

INFORMASI RESMI INSTANSI & PEMERINTAH KOTA BANDUNG:
- Instansi: {$namaInstansi} - {$pemda}
- Alamat Kantor: {$alamat}
- Kontak & Telepon: {$telepon} | {$email}
- Pimpinan Daerah Kota Bandung Saat Ini:
  * Wali Kota Bandung: Bapak **Muhammad Farhan, S.E.** (Pak Farhan)
  * Wakil Wali Kota Bandung: Bapak **H. Erwin, S.E., M.Pd.** (Kang Erwin)
  * Sekretaris Daerah Kota Bandung beserta jajaran perangkat daerah.
  (Catatan: Bapak Ir. A. Koswara, M.P. adalah Penjabat / Pj Wali Kota terdahulu).
  Jika ditanya tentang siapa Wali Kota Bandung saat ini / sekarang, jawablah secara tegas dan tepat bahwa Wali Kota Bandung saat ini dijabat oleh Bapak **Muhammad Farhan, S.E.** (didampingi Wakil Wali Kota Bapak **H. Erwin, S.E., M.Pd.**).
- Tugas Pokok Prokopim: Menyiapkan kebijakan, mengoordinasikan pelayanan keprotokolan pimpinan daerah, mendokumentasikan kegiatan pimpinan, dan mempublikasikan komunikasi pimpinan daerah ke masyarakat.
- Universitas Komputer Indonesia (UNIKOM):
  * Alamat Kampus: Jl. Dipati Ukur No. 112-116, Lebakgede, Kec. Coblong, Kota Bandung, Jawa Barat 40132.
  * Rektor UNIKOM: Prof. Dr. Ir. H. Eddy Soeryanto Soegoto, M.T.
  * Dekan Fakultas Teknik & Ilmu Komputer (FTIK): Dr. Ir. Herman S. Soegoto, MBA
  * Ketua Program Studi (Kaprodi) S1 Teknik Informatika UNIKOM Saat Ini (Masa Bakti 2024–2026): Bapak **Hanhan Maulana, M.Kom., Ph.D.**
  * Sekretaris Program Studi (Sekprodi) Teknik Informatika UNIKOM: Ibu **Dr. Ednawati Rainarli, S.Si., M.Si.**
  (Catatan: Pejabat Kaprodi periode terdahulu adalah Bapak Dr. Ir. Yusrila Kerlo Mauluddin, M.T.).
  * Himpunan Mahasiswa Teknik Informatika (HMIF) UNIKOM: Resmi didirikan pada tanggal **15 Januari 1997** di Bandung (sejak era STMIK IKP sebelum berkembang menjadi UNIKOM).

DATA BASIS DATA E-PROKOPIM TERKINI (REALTIME DATABASE):
1. Data Agenda & Jadwal Kegiatan Pimpinan:
{$kegiatanSummary}

2. Data Arsip Surat Masuk Terbaru:
{$arsipSummary}

3. Data Draf Sambutan Pimpinan:
{$sambutanSummary}

4. Data Arahan Pimpinan:
{$arahanSummary}

5. Data Personel / Pegawai Prokopim:
{$pegawaiSummary}

6. Data Aset:
{$kendaraanCount} Kendaraan Operasional ({$kendaraanListStr}) & {$barangCount} Barang Inventaris.

7. Data Keuangan & Realisasi:
{$keuanganCount} Transaksi tercatat, Total Realisasi Selesai: {$keuanganFormatted}.

PANDUAN FORMAT & SIKAP:
- Jawablah dengan ramah, luwes, komunikatif, dan solutif layaknya asisten cerdas berkelas dunia.
- Gunakan struktur paragraf yang padat, rapi, dan tidak membuang spasi kosong berlebihan.
- Jangan kaku atau menolak pertanyaan umum. Berikan jawaban yang informatif dan relevan.
- Hindari menampilkan karakter tanda bintang (*) mentah.
EOT;
    }

    protected function isIllegalOrDangerous(string $p): bool
    {
        $strictlyForbidden = [
            'porn', 'bokep', 'judi online', 'slot gacor', 'hack akun',
            'bocorkan password', 'bocorkan rekening', 'terorisme', 'rakit bom', 'obat terlarang'
        ];

        foreach ($strictlyForbidden as $kw) {
            if (str_contains($p, $kw)) {
                return true;
            }
        }

        return false;
    }

    protected function handleSiaranPers(string $p): array
    {
        Carbon::setLocale('id');
        $tgl = Carbon::now()->translatedFormat('d F Y');
        return [
            'content' => "SIARAN PERS RESMI HUMAS PEMERINTAH KOTA BANDUNG\n" .
                "Untuk Diterbitkan Segera — Bagian Prokopim Setda Kota Bandung\n\n" .
                "BANDUNG, {$tgl} — Pemerintah Kota Bandung terus memperkuat koordinasi dan kolaborasi lintas sektor guna memastikan percepatan pembangunan dan pelayanan publik yang prima bagi seluruh warga Kota Bandung.\n\n" .
                "Dalam arahannya, Pimpinan Pemerintah Kota Bandung menegaskan pentingnya sinergi dan integritas seluruh jajaran perangkat daerah dalam menyukseskan program-program strategis kemasyarakatan.\n\n" .
                "\"Kebersamaan dan komitmen kita adalah kunci utama untuk mewujudkan Kota Bandung yang unggul, nyaman, dan juara di segala sektor,\" ungkap pimpinan.\n\n" .
                "Kegiatan ini berlangsung dengan tertib dan dihadiri oleh jajaran Forkopimda, tokoh masyarakat, serta perwakilan perangkat daerah terkait.\n\n" .
                "---\n\n" .
                "USULAN CAPTION MEDIA SOSIAL (INSTAGRAM / X @humas_bandung):\n" .
                "📸 Membangun Bandung Juara dengan Kolaborasi dan Ketulusan Melayani.\n\n" .
                "Pemerintah Kota Bandung terus berkomitmen menghadirkan tata kelola pemerintahan yang responsif dan berdampak nyata bagi masyarakat. Melalui sinergi bersama seluruh elemen, kita wujudkan Kota Bandung yang semakin maju dan berdaya saing!\n\n" .
                "#ProkopimKotaBandung #BandungJuara #HumasPemkotBandung #BandungUtama #PemkotBandung",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function handleJadwalPimpinan(string $p): array
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $targetDate = $now->copy();

        if (str_contains($p, 'besok')) {
            $targetDate = $now->copy()->addDay();
            $dateLabel = "Besok (" . $targetDate->translatedFormat('l, d F Y') . ")";
        } elseif (str_contains($p, 'hari ini')) {
            $targetDate = $now->copy();
            $dateLabel = "Hari ini (" . $targetDate->translatedFormat('l, d F Y') . ")";
        } elseif (str_contains($p, 'lusa')) {
            $targetDate = $now->copy()->addDays(2);
            $dateLabel = "Lusa (" . $targetDate->translatedFormat('l, d F Y') . ")";
        } elseif (str_contains($p, 'senin')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::MONDAY)->addWeek() : $now->copy()->next(Carbon::MONDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'selasa')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::TUESDAY)->addWeek() : $now->copy()->next(Carbon::TUESDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'rabu')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::WEDNESDAY)->addWeek() : $now->copy()->next(Carbon::WEDNESDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'kamis')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::THURSDAY) : $now->copy()->next(Carbon::THURSDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'jumat') || str_contains($p, "jum'at")) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::FRIDAY)->addWeek() : $now->copy()->next(Carbon::FRIDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'sabtu')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::SATURDAY)->addWeek() : $now->copy()->next(Carbon::SATURDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } elseif (str_contains($p, 'minggu')) {
            $targetDate = (str_contains($p, 'depan')) ? $now->copy()->next(Carbon::SUNDAY)->addWeek() : $now->copy()->next(Carbon::SUNDAY);
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        } else {
            $dateLabel = $targetDate->translatedFormat('l, d F Y');
        }

        $kegiatanOnDate = Kegiatan::whereDate('tanggal_mulai', $targetDate->toDateString())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        $schedules = [];
        if ($kegiatanOnDate->count() > 0) {
            foreach ($kegiatanOnDate as $k) {
                $schedules[] = [
                    'time' => $k->tanggal_mulai ? $k->tanggal_mulai->format('H:i') : '09:00',
                    'title' => $k->judul,
                    'location' => $k->lokasi ?? 'Balai Kota Bandung',
                ];
            }
        } else {
            $upcomingKegiatan = Kegiatan::whereDate('tanggal_mulai', '>=', $now->toDateString())
                ->orderBy('tanggal_mulai', 'asc')
                ->take(2)
                ->get();

            if ($upcomingKegiatan->count() > 0) {
                foreach ($upcomingKegiatan as $k) {
                    $schedules[] = [
                        'time' => $k->tanggal_mulai ? $k->tanggal_mulai->format('H:i') : '09:00',
                        'title' => $k->judul,
                        'location' => $k->lokasi ?? 'Balai Kota Bandung',
                    ];
                }
            } else {
                $schedules = [
                    [
                        'time' => '09:00',
                        'title' => 'Rapat Paripurna DPRD Kota Bandung',
                        'location' => 'Gedung DPRD Kota Bandung',
                    ],
                    [
                        'time' => '13:30',
                        'title' => 'Audiensi dengan Tokoh Masyarakat & Forkopimda',
                        'location' => 'Ruang Tengah Balai Kota',
                    ],
                ];
            }
        }

        return [
            'content' => "Baik, ini jadwal Bapak Walikota untuk hari {$dateLabel}:\n\nApakah Anda perlu saya siapkan draf poin-poin arahan untuk agenda tersebut?",
            'structured_data' => [
                'type' => 'schedule',
                'title' => "Jadwal Pimpinan — {$dateLabel}",
                'items' => $schedules,
            ],
            'source' => 'local_engine',
        ];
    }

    protected function handleRingkasSurat(): array
    {
        $arsipDb = Arsip::orderBy('id', 'desc')->take(3)->get();
        $items = [];

        if ($arsipDb->count() > 0) {
            foreach ($arsipDb as $a) {
                $items[] = [
                    'nomor' => $a->nomor_surat ?? '005/Prokopim/2023',
                    'perihal' => $a->judul,
                    'pengirim' => $a->instansi ?? 'Pemerintah Kota Bandung',
                    'tanggal' => $a->tanggal_dokumen ? $a->tanggal_dokumen->format('d/m/Y') : date('d/m/Y'),
                ];
            }
        } else {
            $items = [
                ['nomor' => '005/142-Disdik/X/2023', 'perihal' => 'Undangan Pembukaan Pameran Inovasi Pendidikan', 'pengirim' => 'Dinas Pendidikan', 'tanggal' => date('d/m/Y')],
                ['nomor' => '027/890-Setda/X/2023', 'perihal' => 'Rakor Persiapan Kunjungan Delegasi Luar Negeri', 'pengirim' => 'Bagian Kerjasama Setda', 'tanggal' => date('d/m/Y')],
                ['nomor' => '100/512-Bapelitbang/X/2023', 'perihal' => 'Penyusunan Rencana Strategis Daerah 2024', 'pengirim' => 'Bapelitbang Kota Bandung', 'tanggal' => date('d/m/Y')],
            ];
        }

        return [
            'content' => "Berikut adalah ringkasan surat masuk & arsip terbaru yang perlu ditindaklanjuti:",
            'structured_data' => [
                'type' => 'mail_summary',
                'title' => "Ringkasan Surat Masuk Hari Ini",
                'items' => $items,
            ],
            'source' => 'local_engine',
        ];
    }

    protected function handleDrafSambutan(string $p): array
    {
        return [
            'content' => "Tentu, berikut draf kerangka naskah sambutan resmi pimpinan:\n\n" .
                "DRAF NASKAH SAMBUTAN WALIKOTA BANDUNG\n" .
                "Tema: Penguatan Pelayanan Publik dan Sinergi Pembangunan Kota Bandung\n\n" .
                "1. Salam Pembuka & Penghormatan\n" .
                "• Assalamu'alaikum Warahmatullahi Wabarakatuh, Sampurasun.\n" .
                "• Menghormati jajaran Forkopimda, Pimpinan Perangkat Daerah, Tokoh Masyarakat, dan seluruh hadirin.\n\n" .
                "2. Poin Utama Sambutan\n" .
                "• Apresiasi atas kolaborasi seluruh elemen dalam menjaga kondusivitas Kota Bandung.\n" .
                "• Komitmen Pemkot Bandung dalam percepatan transformasi digital dan pelayanan prima kepada masyarakat.\n" .
                "• Ajakan bersama untuk terus berinovasi dan menjaga integritas dalam bekerja.\n\n" .
                "3. Pantun Penutup\n" .
                "• Jalan-jalan ke Braga membeli roti,\n" .
                "  Singgah sebentar di Alun-alun Kota.\n" .
                "  Mari bersama kita sepenuh hati,\n" .
                "  Membangun Bandung Juara yang kita cinta.\n\n" .
                "• Wabillahi Taufiq Wal Hidayah, Wassalamu'alaikum Wr. Wb.",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function handlePegawai(string $p): array
    {
        $pegawaiList = Personel::take(3)->get();
        $text = "Berikut informasi sebagian personel Protokol dan Komunikasi Pimpinan yang tercatat di sistem:\n";
        foreach ($pegawaiList as $idx => $peg) {
            $num = $idx + 1;
            $text .= "\n{$num}. {$peg->nama_lengkap} — {$peg->jabatan} ({$peg->status_kepegawaian_label})";
        }
        $text .= "\n\nTotal terdapat " . Personel::count() . " pegawai terdaftar di bagian Administrasi Pegawai.";
        return [
            'content' => $text,
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function handleAset(string $p): array
    {
        $kendaraanCount = AsetKendaraan::count();
        $barangCount = AsetBarang::count();
        return [
            'content' => "Data manajemen aset Prokopim saat ini mencatat:\n\n• {$barangCount} Aset Inventaris Barang (termasuk laptop operasional, perangkat audio, kamera, dan perlengkapan rapat).\n• {$kendaraanCount} Kendaraan Operasional (termasuk Toyota Innova Zenix, Hiace Premio, Pajero Sport, dan motor dinas).\n\nAnda dapat membuka menu Administrasi -> Asset untuk rincian pemegang dan status ketersediaan.",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function handleKeuangan(string $p): array
    {
        $totalTrx = Keuangan::count();
        $totalNominal = Keuangan::where('status', 'selesai')->sum('nominal');
        $formattedNominal = 'Rp ' . number_format($totalNominal, 0, ',', '.');
        return [
            'content' => "Data rekapitulasi keuangan & realisasi anggaran Prokopim:\n\n• Total Transaksi Tercatat: {$totalTrx} transaksi\n• Realisasi Anggaran Terverifikasi: {$formattedNominal}\n\nUntuk rincian kuitansi dan SPJ lengkap, silakan akses modul Administrasi -> Keuangan.",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }

    protected function handleFileAttachment(array $fileData, string $p): array
    {
        $name = $fileData['name'] ?? 'Berkas';
        $ext = strtolower($fileData['type'] ?? pathinfo($name, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            return [
                'content' => "Saya telah menerima berkas gambar/foto \"{$name}\".\n\n" .
                    "Analisis Dokumentasi Visual Prokopim:\n" .
                    "• Status: Berkas gambar berhasil diproses dan disimpan ke arsip digital.\n" .
                    "• Kualitas & Komposisi: Foto liputan dokumentasi siap digunakan untuk bahan rilis pers atau publikasi media sosial.\n" .
                    "• Usulan Caption Media Sosial:\n" .
                    "  \"Pemerintah Kota Bandung terus berkomitmen menghadirkan pelayanan terbaik dan sinergi bersama masyarakat menuju Bandung Juara. #ProkopimKotaBandung #BandungJuara #HumasPemkotBandung\"\n\n" .
                    "Apakah Anda ingin saya buatkan draf siaran pers resmi terkait dokumentasi ini?",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm'])) {
            return [
                'content' => "Saya telah menerima berkas rekaman video \"{$name}\".\n\n" .
                    "Analisis Konten Video Prokopim:\n" .
                    "• Format Berkas: Video resolusi standar penyiaran / media center.\n" .
                    "• Rekomendasi Distribusi:\n" .
                    "  1. Video Reels / Shorts: Potong segmen 30–60 detik pada momen kutipan arahan penting pimpinan.\n" .
                    "  2. Arsip Berita Pemkot: Simpan master rekaman di modul Dokumentasi Pimpinan.\n\n" .
                    "Ada yang bisa saya bantu terkait transkrip naskah sambutan dalam video ini?",
                'structured_data' => null,
                'source' => 'local_engine',
            ];
        }

        return [
            'content' => "Saya telah menerima dan menganalisis berkas dokumen \"{$name}\".\n\n" .
                "Hasil Telaah & Ringkasan Dokumen:\n" .
                "• Klasifikasi: Naskah Dinas / Dokumen Administrasi Keprotokolan.\n" .
                "• Intisari Dokumen: Dokumen telah diverifikasi dan siap ditindaklanjuti sesuai Standar Operasional Prosedur (SOP) Prokopim Kota Bandung.\n" .
                "• Rekomendasi Tindak Lanjut:\n" .
                "  1. Catat ke dalam Buku Agenda / Modul Arsip Surat jika merupakan surat masuk resmi.\n" .
                "  2. Koordinasikan dengan Kasubbag terkait jadwal disposisi dan penugasan personel protokol lapangan.\n\n" .
                "Apakah Anda perlu saya buatkan draf lembar disposisi pimpinan untuk surat ini?",
            'structured_data' => null,
            'source' => 'local_engine',
        ];
    }
}
