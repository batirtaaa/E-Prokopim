<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsetBarang extends Model
{
    protected $table = 'aset_barang';

    protected $fillable = [
        'kode_aset',
        'nama_barang',
        'kategori',
        'tanggal_perolehan',
        'lokasi',
        'penanggung_jawab',
        'kondisi',
        'status',
        'foto_barang',
        'dokumen_pendukung',
        'created_by',
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status)) {
            'tersedia' => 'Tersedia',
            'digunakan' => 'Digunakan',
            'dipinjam' => 'Dipinjam',
            'dalam_perbaikan', 'perbaikan' => 'Dalam Perbaikan',
            'dihapuskan' => 'Dihapuskan',
            default => ucfirst($this->status),
        };
    }

    public static function generateNextCode(): string
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        if ($last && preg_match('/INV-' . $year . '-(\d+)/', $last->kode_aset, $matches)) {
            $nextNum = intval($matches[1]) + 1;
        } else {
            $count = self::count() + 1;
            $nextNum = $count;
        }
        return sprintf('INV-%s-%03d', $year, $nextNum);
    }
}
