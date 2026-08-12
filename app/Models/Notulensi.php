<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notulensi extends Model
{
    use SoftDeletes;
    protected $table = 'notulensi';
    protected $fillable = [
        'kegiatan_id', 'judul', 'tanggal_rapat', 'tempat', 'peserta',
        'agenda', 'isi_notulensi', 'kesimpulan', 'tindak_lanjut',
        'file_notulensi', 'status', 'notulis_id', 'created_by',
    ];
    protected $casts = ['tanggal_rapat' => 'datetime'];
    public function kegiatan() { return $this->belongsTo(Kegiatan::class); }
    public function notulis() { return $this->belongsTo(User::class, 'notulis_id'); }
}

