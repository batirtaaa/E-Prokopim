<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AnalisisIsu extends Model
{
    use SoftDeletes;

    protected $table = 'analisis_isu';

    protected $fillable = [
        'judul',
        'tanggal',
        'jenis_media',
        'sumber_isu',
        'analisis',
        'rekomendasi_kebijakan',
        'rekomendasi_publikasi',
        'leading_sector',
        'sentimen',
        'link_sumber',
        'file_lampiran',
        'file_name',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getHariTanggalAttribute(): string
    {
        if (!$this->tanggal) {
            return '-';
        }

        $hariMap = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $bulanMap = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $carbon = Carbon::parse($this->tanggal);
        $hari = $hariMap[$carbon->format('l')] ?? $carbon->format('l');
        $bulan = $bulanMap[$carbon->month] ?? $carbon->format('F');

        return "{$hari}, {$carbon->format('d')} {$bulan} {$carbon->format('Y')}";
    }

    public function getSentimenBadgeClassAttribute(): string
    {
        return match($this->sentimen) {
            'Positif' => 'badge-positif',
            'Negatif' => 'badge-negatif',
            default   => 'badge-netral',
        };
    }

    public function getJenisMediaBadgeClassAttribute(): string
    {
        return match($this->jenis_media) {
            'Sosial' => 'badge-media-sosial',
            'Online' => 'badge-media-online',
            'Cetak'  => 'badge-media-cetak',
            default  => 'badge-media-default',
        };
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_lampiran) {
            return asset('storage/' . $this->file_lampiran);
        }
        return null;
    }
}
