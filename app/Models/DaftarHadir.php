<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarHadir extends Model
{
    use SoftDeletes;
    protected $table = 'daftar_hadir';
    protected $fillable = [
        'kegiatan_id', 'personel_id', 'nama_peserta', 'jabatan', 'instansi',
        'status_hadir', 'jam_hadir', 'tanda_tangan', 'keterangan',
    ];
    public function kegiatan() { return $this->belongsTo(Kegiatan::class); }
    public function personel() { return $this->belongsTo(Personel::class); }
}
