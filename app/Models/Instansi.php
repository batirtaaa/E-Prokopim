<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = [
        'nama_instansi', 'pemerintah_daerah', 'alamat_lengkap',
        'email_kontak', 'nomor_telepon', 'logo', 'website',
    ];

    public static function getDefault(): ?self
    {
        return static::first();
    }
}
