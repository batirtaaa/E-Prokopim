<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriArsip extends Model
{
    protected $table = 'galeri_arsip';

    protected $fillable = [
        'kode',
        'judul',
        'tipe',
        'akses',
        'file_path',
        'file_name',
        'durasi_detik',
        'jumlah_foto',
        'keterangan',
        'tanggal_kegiatan',
        'kegiatan_id',
        'created_by',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Kegiatan::class, 'kegiatan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'foto'      => 'Foto',
            'video'     => 'Video',
            'notulensi' => 'Notulensi',
            default     => ucfirst($this->tipe),
        };
    }

    public function getDurasiFormatAttribute(): ?string
    {
        if (!$this->durasi_detik) return null;
        $m = intdiv($this->durasi_detik, 60);
        $s = $this->durasi_detik % 60;
        return sprintf('%d:%02d', $m, $s);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return '';
    }

    public function getAksesLabelAttribute(): string
    {
        return ucfirst($this->akses);
    }

    public static function generateKode(): string
    {
        $year = now()->format('y');
        $last = static::whereYear('created_at', now()->year)->count();
        return '#KG-' . $year . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
