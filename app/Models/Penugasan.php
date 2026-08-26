<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penugasan extends Model
{
    protected $table = 'penugasan';
    protected $fillable = [
        'kegiatan_id', 'personel_id', 'peran', 'status', 'catatan',
        'assigned_by', 'confirmed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function personel(): BelongsTo
    {
        return $this->belongsTo(Personel::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'ditugaskan' => 'Ditugaskan',
            'dikonfirmasi' => 'Dikonfirmasi',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
            'tidak_hadir' => 'Tidak Hadir',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'ditugaskan' => 'yellow',
            'dikonfirmasi' => 'green',
            'berlangsung' => 'blue',
            'selesai' => 'gray',
            'tidak_hadir' => 'red',
            default => 'gray',
        };
    }
}
