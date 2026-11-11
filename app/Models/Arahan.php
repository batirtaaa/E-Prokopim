<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arahan extends Model
{
    use SoftDeletes;
    protected $table = 'arahan';
    protected $fillable = [
        'nomor_arahan', 'judul', 'isi_arahan', 'pimpinan', 'ditujukan_kepada',
        'tanggal_arahan', 'deadline', 'prioritas', 'status', 'file_arahan', 'created_by',
    ];
    protected $casts = [
        'tanggal_arahan' => 'date',
        'deadline' => 'date',
    ];

    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }

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

    public function getPrioritasColorAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'green',
            'sedang' => 'blue',
            'tinggi' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Mengembalikan status efektif: jika deadline sudah lewat dan belum selesai,
     * otomatis dianggap melewati_deadline meski belum tersimpan di DB.
     */
    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status !== 'selesai' && $this->deadline && $this->deadline->lt(now()->startOfDay())) {
            return 'melewati_deadline';
        }
        return $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->effective_status) {
            'belum_selesai' => 'blue',
            'sedang_berjalan' => 'yellow',
            'selesai' => 'green',
            'melewati_deadline' => 'red',
            default => 'gray',
        };
    }
}
