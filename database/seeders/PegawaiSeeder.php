<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $csvData = [
            ['BUDI RAHMAT TAUFIK, AP., MM', '197307111994031004', 'Kepala Bagian Protokol dan Komunikasi Pimpinan', 'PNS', 'protokol', 'budi.rahmat@bandung.go.id'],
            ['ANDRE PRATAMA, S.I.Kom.,M.Si', '198704032011011004', 'Kepala Sub Bagian Protokol', 'PNS', 'protokol', 'andre.pratama@bandung.go.id'],
            ['PRIMANDA WIJAKSANA, S.Sos', '197901112009011004', 'Pranata Hubungan Masyarakat Ahli Muda', 'PNS', 'dokumentasi', 'primanda.w@bandung.go.id'],
            ['SUHENDRO DRADJAD, ST', '197601212009021001', 'Pranata Hubungan Masyarakat Ahli Muda', 'PNS', 'dokumentasi', 'suhendro.d@bandung.go.id'],
            ['ANGGI AGASI PRAMADAN, S.I.Kom', '198604232010011008', 'Penelaah Teknis Kebijakan', 'PNS', 'protokol', 'anggi.agasi@bandung.go.id'],
            ['IRNA ARIANI, S.ST., MT.', '198604022015032003', 'Penelaah Teknis Kebijakan', 'PNS', 'protokol', 'irna.ariani@bandung.go.id'],
            ['WIWID SEPTIYARDI, S.I.Kom, M.A.', '199209042019031016', 'Penelaah Teknis Kebijakan', 'PNS', 'protokol', 'wiwid.septiyardi@bandung.go.id'],
            ['SITI MARYAM DELINA FRONIKA, S.I.Kom.', '199603242020122011', 'Penelaah Teknis Kebijakan', 'PNS', 'protokol', 'siti.maryam@bandung.go.id'],
            ['WILDATUL HOMSAH MUNIROH, S.I.Kom', '199010202014032006', 'Pengolah Data Dan Informasi', 'PNS', 'dokumentasi', 'wildatul.homsah@bandung.go.id'],
            ['KARINA APRINDA PRADANI, S.Tr.IP', '199804222022082001', 'Penata Keprotokolan', 'PNS', 'protokol', 'karina.aprinda@bandung.go.id'],
            ['RINANDA RATNA UTAMA RICKY, S.Hub.Int', '199910012025042009', 'Penata Keprotokolan', 'PNS', 'protokol', 'rinanda.ratna@bandung.go.id'],
            ['FATWA IMANI, A.Md.', '199902282025042006', 'Pengelola Keprotokolan', 'PNS', 'protokol', 'fatwa.imani@bandung.go.id'],
            ['LIES RIKA FATIMAH, S.I.Kom', '197211232025212001', 'Pranata Hubungan Masyarakat Ahli Pertama', 'PPPK', 'dokumentasi', 'lies.rika@bandung.go.id'],
            ['MUHAMMAD KADAFI, A.Md', '198602142022211002', 'Pranata Hubungan Masyarakat Terampil', 'PPPK', 'dokumentasi', 'muhammad.kadafi@bandung.go.id'],
            ['MUHAMMAD INTAN MUTTAQIEN, A.Md', '198705202023211018', 'Pranata Hubungan Masyarakat Terampil', 'PPPK', 'dokumentasi', 'muhammad.intan@bandung.go.id'],
            ['NADYA AVIANTY PUTRI SABAR, A.Md.I.Kom', '199601302022212001', 'Pranata Hubungan Masyarakat Terampil', 'PPPK', 'dokumentasi', 'nadya.avianty@bandung.go.id'],
            ['AFNI FAUJIAH, S.I.Kom.', '199604042025212092', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'afni.faujiah@bandung.go.id'],
            ['AHMAD MUJADDID ABDURROYAN, S.Psi', '199702212025211055', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'ahmad.mujaddid@bandung.go.id'],
            ['GUMILAR SAYIDUL AKBAR, S.Kom', '199805292025211050', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'dokumentasi', 'gumilar.sayidul@bandung.go.id'],
            ['AJI STIA PINANDITA ROSYADA, S.ST', '199008012025211075', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'aji.stia@bandung.go.id'],
            ['RIZKI ALAMINU, S.I.Kom', '198701132025211077', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'rizki.alaminu@bandung.go.id'],
            ['RIAN ANDRIAN, S.E.', '198302112025211081', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'rian.andrian@bandung.go.id'],
            ['JULIAN HENDRAWAN, S.T.', '199807192025211036', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'dokumentasi', 'julian.hendrawan@bandung.go.id'],
            ['RIF\'ATUR ROHMANIAH, S.I.kom', '199704182025212066', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'rifatur.rohmaniah@bandung.go.id'],
            ['RAHMAT HIDAYAT, S.Ip', '198401052025211067', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'rahmat.hidayat@bandung.go.id'],
            ['IRVAN ADHARI, S.I.Kom.', '198508252025211082', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'irvan.adhari@bandung.go.id'],
            ['NITA ASTRIA NURTANTI, S.Pt', '198806252025212046', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'nita.astria@bandung.go.id'],
            ['MOCHAMAD ANGGA PRATAMA, S.I.Kom.', '199609052025211070', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'mochamad.angga@bandung.go.id'],
            ['REZA MOCHAMAD ZEIN, S.I.Kom.', '199903062025211038', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'reza.mochamad@bandung.go.id'],
            ['ALWAN DZAKI MURTADHO, S.M.', '199808242025211049', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'alwan.dzaki@bandung.go.id'],
            ['RADEN DINAR SITI AYU LESTARI, S.Hum.', '199201012025212186', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'raden.dinar@bandung.go.id'],
            ['FREDI HANDOKO, S.I.K.', '199512302025211060', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'fredi.handoko@bandung.go.id'],
            ['JANETE MIA PERMANA, S.Pd.', '199201212025212074', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'janete.mia@bandung.go.id'],
            ['YANUAR BRAMANTYA, S.T.Sn.', '199101042025211065', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'dokumentasi', 'yanuar.bramantya@bandung.go.id'],
            ['AGVI FIRDAUS, S.Sos.', '199106122025211088', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'agvi.firdaus@bandung.go.id'],
            ['PENDRA YOGAS SUWARNA, S.S.', '199202102025211103', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'pendra.yogas@bandung.go.id'],
            ['YUDHA PRATAMA, S.Tr.Kom.', '199312062025211072', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'dokumentasi', 'yudha.pratama@bandung.go.id'],
            ['MAESYA ZORAYA NURAISHAH, S.H.', '199503162025212073', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'maesya.zoraya@bandung.go.id'],
            ['MUHAMMAD FAHMI MUDZAKIR, S.Pd.', '199702152025211073', 'Penata Layanan Operasional', 'PPPK Paruh Waktu', 'protokol', 'muhammad.fahmi@bandung.go.id'],
            ['OLICH YUSUF EFFENDI', '198405082025211094', 'Operator Layanan Operasional', 'PPPK Paruh Waktu', 'lainnya', 'olich.yusuf@bandung.go.id'],
            ['SHANDI ADISTIA HILMAWAN', '-', 'Tenaga Teknis Penunjang', 'Outsourching', 'lainnya', 'shandi.adistia@bandung.go.id'],
            ['TOMMY ALEXANDER', '-', 'Tenaga Teknis Penunjang', 'Outsourching', 'lainnya', 'tommy.alexander@bandung.go.id'],
            ['ABDUR', '-', 'Tenaga Teknis Penunjang', 'Outsourching', 'lainnya', 'abdur@bandung.go.id'],
        ];

        // Disable foreign key checks to safely refresh personel
        Schema::disableForeignKeyConstraints();
        Personel::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($csvData as $item) {
            Personel::create([
                'nama_lengkap' => $item[0],
                'nip' => $item[1],
                'jabatan' => $item[2],
                'status_kepegawaian' => $item[3],
                'bidang' => $item[4],
                'email' => $item[5],
                'phone' => '08' . rand(11, 99) . rand(1000000, 9999999),
                'status_ketersediaan' => 'standby',
                'user_id' => $adminId,
            ]);
        }
    }
}
