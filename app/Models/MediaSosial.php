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
        return strtoupper($this->platform);
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
