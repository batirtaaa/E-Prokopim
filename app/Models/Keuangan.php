<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keuangan extends Model
{
    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal_diterima',
        'nomor_surat',
        'pengirim',
        'perihal',
        'disposisi',
        'file_dokumen',
        'link_dokumen',
        'is_printed',
        'printed_at',
        // Legacy fields retained for backward compatibility
        'no_bukti',
        'tanggal',
        'uraian',
        'kategori',
        'jenis',
        'nominal',
        'penanggung_jawab',
        'status',
        'file_bukti',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_diterima' => 'date',
        'tanggal' => 'date',
        'is_printed' => 'boolean',
        'printed_at' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedTanggalDiterimaAttribute(): string
    {
        $date = $this->tanggal_diterima ?? $this->tanggal;
        if (!$date) {
            return '-';
        }

        $bulanMap = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $carbon = Carbon::parse($date);
        $bulan = $bulanMap[$carbon->month] ?? $carbon->format('F');
        return "{$carbon->format('d')} {$bulan} {$carbon->format('Y')}";
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_dokumen) {
            return asset('storage/' . $this->file_dokumen);
        }
        if ($this->file_bukti) {
            return asset('storage/' . $this->file_bukti);
        }
        return null;
    }
}
