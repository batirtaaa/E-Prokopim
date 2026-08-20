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
        'nomor_agenda', 'judul', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai',
        'pimpinan', 'status', 'kategori', 'foto_kegiatan', 'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'pimpinan' => 'array',
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

    public function getPimpinanListAttribute(): array
    {
        $val = $this->pimpinan;
        if (is_array($val)) {
            return $val;
        }
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return [$val];
        }
        return [];
    }

    public function getPimpinanBadgesAttribute(): array
    {
        $list = $this->pimpinan_list;
        $map = [
            'wali_kota'       => ['initial' => 'WK', 'name' => 'Wali Kota'],
            'wakil_wali_kota' => ['initial' => 'VW', 'name' => 'Wakil Wali Kota'],
            'sekda'           => ['initial' => 'SD', 'name' => 'Sekretaris Daerah'],
            'pkk1'            => ['initial' => 'PK1', 'name' => 'Aryatri Benarto (PKK1)'],
            'pkk2'            => ['initial' => 'PK2', 'name' => 'Fitriana Dewi (PKK2)'],
            'dwp'             => ['initial' => 'DWP', 'name' => 'R. Dewi Pertiwi Zulkarnain (DWP)'],
            'asisten'         => ['initial' => 'AS', 'name' => 'Asisten'],
        ];

        $badges = [];
        foreach ($list as $p) {
            if (isset($map[$p])) {
                $badges[] = $map[$p];
            } elseif (!empty($p)) {
                $badges[] = ['initial' => strtoupper(substr($p, 0, 2)), 'name' => ucfirst($p)];
            }
        }
        return $badges;
    }

    public function getPimpinanLabelAttribute(): string
    {
        $badges = $this->pimpinan_badges;
        if (empty($badges)) {
            return '—';
        }
        return implode(', ', array_column($badges, 'name'));
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'terjadwal', 'publish', 'published' => 'Terjadwal',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'terjadwal', 'publish', 'published' => 'blue',
            'berlangsung' => 'green',
            'selesai' => 'gray',
            'dibatalkan' => 'red',
            'draft' => 'orange',
            default => 'gray',
        };
    }
}
