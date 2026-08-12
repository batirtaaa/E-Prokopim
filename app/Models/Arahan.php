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
            'urgent' => 'red',
            default => 'gray',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'belum_selesai' => 'blue',
            'sedang_berjalan' => 'yellow',
            'selesai' => 'green',
            'melewati_deadline' => 'red',
            default => 'gray',
        };
    }
}
