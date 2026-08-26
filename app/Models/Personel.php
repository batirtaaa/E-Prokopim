<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personel extends Model
{
    protected $table = 'personel';
    protected $fillable = [
        'user_id', 'nama_lengkap', 'email', 'nip', 'jabatan', 'status_kepegawaian', 'bidang',
        'phone', 'photo', 'status_ketersediaan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penugasan(): HasMany
    {
        return $this->hasMany(Penugasan::class);
    }

    public function getBidangLabelAttribute(): string
    {
        return match($this->bidang) {
            'protokol' => 'Protokol',
            'mc' => 'MC',
            'fotografer' => 'Fotografer',
            'videografer' => 'Videografer',
            'notulis' => 'Notulis',
            'dokumentasi' => 'Dokumentasi',
            default => ucfirst($this->bidang),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_ketersediaan) {
            'standby' => 'STANDBY',
            'bertugas' => 'BERTUGAS',
            'cuti' => 'CUTI',
            'tidak_aktif' => 'TIDAK AKTIF',
            default => strtoupper($this->status_ketersediaan),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status_ketersediaan) {
            'standby' => 'blue',
            'bertugas' => 'green',
            'cuti' => 'gray',
            'tidak_aktif' => 'red',
            default => 'gray',
        };
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->nama_lengkap);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    public function getStatusKepegawaianBadgeClassAttribute(): string
    {
        $status = strtolower(trim($this->status_kepegawaian ?? ''));
        return match(true) {
            $status === 'pns' => 'status-pns',
            str_contains($status, 'paruh') => 'status-pppk-paruh',
            str_contains($status, 'penuh') => 'status-pppk-penuh',
            $status === 'pppk' => 'status-pppk-penuh',
            str_contains($status, 'outsourc') => 'status-outsourcing',
            str_contains($status, 'honorer') => 'status-honorer',
            default => 'status-default',
        };
    }

    public function getStatusKepegawaianLabelAttribute(): string
    {
        return $this->status_kepegawaian ?: 'PNS';
    }

    public function getDisplayEmailAttribute(): string
    {
        if (!empty($this->email)) {
            return $this->email;
        }
        if ($this->user && !empty($this->user->email)) {
            return $this->user->email;
        }
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $this->nama_lengkap)[0] ?? 'pegawai'));
        return $slug . '@bandung.go.id';
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }
}
