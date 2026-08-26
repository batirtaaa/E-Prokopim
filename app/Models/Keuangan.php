<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keuangan extends Model
{
    protected $table = 'keuangan';

    protected $fillable = [
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
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedNominalAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status)) {
            'selesai', 'lunas' => 'Selesai',
            'pending' => 'Menunggu Verifikasi',
            'proses' => 'Sedang Diproses',
            'draft' => 'Draft',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match(strtolower($this->status)) {
            'selesai', 'lunas' => 'status-pns',      // soft blue pill
            'pending' => 'status-pppk-paruh',        // soft slate pill
            'proses' => 'status-pppk-penuh',         // soft purple pill
            'draft' => 'status-outsourcing',         // soft gray pill
            default => 'status-default',
        };
    }

    public static function generateNextCode(): string
    {
        $year = date('Y');
        $last = self::whereYear('tanggal', $year)->orderBy('id', 'desc')->first();
        if ($last && preg_match('/TRX-' . $year . '-(\d+)/', $last->no_bukti, $matches)) {
            $nextNum = intval($matches[1]) + 1;
        } else {
            $count = self::count() + 1;
            $nextNum = $count;
        }
        return sprintf('TRX-%s-%03d', $year, $nextNum);
    }
}
