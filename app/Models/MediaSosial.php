<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaSosial extends Model
{
    protected $table = 'media_sosial';

    protected $fillable = [
        'judul',
        'kategori',
        'sub_kategori',
        'platform',
        'deskripsi',
        'file_path',
        'file_name',
        'tanggal_publikasi',
        'status',
        'link_post',
        'created_by',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getPlatformLabelAttribute(): string
    {
        return match($this->platform) {
            'x_twitter' => 'X (Twitter)',
            'youtube'   => 'YouTube',
            'tiktok'    => 'TikTok',
            'instagram' => 'Instagram',
            'facebook'  => 'Facebook',
            'billboard' => 'Billboard',
            'videotron' => 'Videotron',
            'baliho'    => 'Baliho',
            'spanduk'   => 'Spanduk',
            default     => ucfirst($this->platform),
        };
    }

    public function getSubKategoriLabelAttribute(): string
    {
        return match($this->sub_kategori) {
            'hari_besar'     => 'Hari Besar',
            'obituary'       => 'Obituary',
            'kamis_nyunda'   => 'Kamis Nyunda',
            'giat_pimpinan'  => 'Giat Pimpinan',
            null, ''         => 'Lainnya',
            default          => $this->sub_kategori, // teks bebas
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'dipublikasi' => 'Dipublikasi',
            'draft'       => 'Draft',
            'dijadwalkan' => 'Dijadwalkan',
            default       => ucfirst($this->status),
        };
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return '';
    }
}
