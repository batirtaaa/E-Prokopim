<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsetKendaraan extends Model
{
    protected $table = 'aset_kendaraan';

    protected $fillable = [
        'plat_nomor',
        'nama_kendaraan',
        'jenis',
        'pemegang_pengguna',
        'tahun',
        'status',
        'foto',
        'dokumen',
        'catatan',
        'created_by',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status)) {
            'sedang_digunakan', 'digunakan' => 'Sedang Digunakan',
            'tersedia' => 'Tersedia',
            'perbaikan', 'dalam_perbaikan' => 'Perbaikan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match(strtolower($this->status)) {
            'sedang_digunakan', 'digunakan' => 'sedang_digunakan',
            'tersedia' => 'tersedia',
            'perbaikan', 'dalam_perbaikan' => 'perbaikan',
            default => 'tersedia',
        };
    }
}
