<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sambutan extends Model
{
    use SoftDeletes;

    protected $table = 'sambutan';

    protected $fillable = [
        'nomor_surat', 'tanggal_surat', 'tanggal_acara', 'asal_instansi', 'tujuan',
        'perihal', 'deskripsi_singkat', 'tanggal_terima', 'tenggat_waktu', 'deadline_at',
        'file_path', 'file_name', 'status_urgensi', 'instruksi_disposisi',
        'petugas_id', 'jenis', 'status', 'created_by',
    ];

    protected $casts = [
        'tanggal_surat'  => 'date',
        'tanggal_acara'  => 'date',
        'tanggal_terima' => 'date',
        'tenggat_waktu'  => 'date',
        'deadline_at'    => 'datetime',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Personel::class, 'petugas_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUrgensiColorAttribute(): string
    {
        return match($this->status_urgensi) {
            'penting' => 'red',
            'segera'  => 'orange',
            default   => 'gray',
        };
    }

    public function getUrgensiLabelAttribute(): string
    {
        return match($this->status_urgensi) {
            'penting' => 'Penting',
            'segera'  => 'Segera',
            default   => 'Biasa',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'selesai'  => 'Selesai',
            'diproses' => 'Progres',
            default    => 'Draft',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'selesai'  => 'sb-status-selesai',
            'diproses' => 'sb-status-progres',
            default    => 'sb-status-draft',
        };
    }
}
