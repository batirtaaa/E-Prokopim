<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumentasi extends Model
{
    use SoftDeletes;
    protected $table = 'dokumentasi';
    protected $fillable = [
        'kegiatan_id', 'judul', 'deskripsi', 'tipe', 'file_path', 'file_name',
        'thumbnail', 'file_size', 'tanggal_dokumentasi', 'fotografer',
        'is_featured', 'uploaded_by',
    ];
    protected $casts = ['tanggal_dokumentasi' => 'date', 'is_featured' => 'boolean'];
    public function kegiatan() { return $this->belongsTo(Kegiatan::class); }
    public function uploadedBy() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
