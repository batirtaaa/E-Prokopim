<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeluar extends Model
{
    use SoftDeletes;
    protected $table = 'surat_keluar';

    protected $fillable = [
        'tanggal_surat',
        'nomor_surat',
        'tujuan',
        'perihal',
        'keterangan',
        'file_dokumen',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedTanggalSuratAttribute(): string
    {
        if (!$this->tanggal_surat) {
            return '-';
        }

        $bulanMap = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember',
        ];

        $carbon = Carbon::parse($this->tanggal_surat);
        $bulan  = $bulanMap[$carbon->month] ?? $carbon->format('F');
        return "{$carbon->format('d')} {$bulan} {$carbon->format('Y')}";
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_dokumen) {
            return asset('storage/' . $this->file_dokumen);
        }
        return null;
    }
}
