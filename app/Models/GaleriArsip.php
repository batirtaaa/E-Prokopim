<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriArsip extends Model
{
    use SoftDeletes;
    protected $table = 'galeri_arsip';

    protected $fillable = [
        'kode',
        'judul',
        'instansi',
        'tipe',
        'akses',
        'file_path',
        'file_name',
        'durasi_detik',
        'jumlah_foto',
        'keterangan',
        'keywords',
        'file_paparan_path',
        'file_paparan_name',
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

    public function getKeywordsListAttribute(): array
    {
        if (empty($this->keywords)) return [];
        return array_values(array_filter(array_map('trim', explode(',', $this->keywords))));
    }

    public function getFilePaparanUrlAttribute(): string
    {
        if ($this->file_paparan_path) {
            return asset('storage/' . $this->file_paparan_path);
        }
        return '';
    }

    public function getHasPaparanAttribute(): bool
    {
        return !empty($this->file_paparan_path);
    }

    public static function generateKode(): string
    {
        $year = now()->format('y');
        $last = static::whereYear('created_at', now()->year)->count();
        return '#KG-' . $year . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
