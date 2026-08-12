<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Kegiatan extends Model
{
    use SoftDeletes;

    protected $table = 'kegiatan';
    protected $fillable = [
        'judul', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai',
        'pimpinan', 'status', 'kategori', 'foto_kegiatan', 'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function penugasan(): HasMany
    {
        return $this->hasMany(Penugasan::class);
    }

    public function notulensi(): HasMany
    {
        return $this->hasMany(Notulensi::class);
    }

    public function dokumentasi(): HasMany
    {
        return $this->hasMany(Dokumentasi::class);
    }

    public function daftarHadir(): HasMany
    {
        return $this->hasMany(DaftarHadir::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getPimpinanLabelAttribute(): string
    {
        return match($this->pimpinan) {
            'wali_kota' => 'Wali Kota',
            'wakil_wali_kota' => 'Wakil Wali Kota',
            'sekda' => 'Sekda',
            'asisten' => 'Asisten',
            default => $this->pimpinan,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'terjadwal' => 'Terjadwal',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'terjadwal' => 'blue',
            'berlangsung' => 'green',
            'selesai' => 'gray',
            'dibatalkan' => 'red',
            default => 'gray',
        };
    }
}
