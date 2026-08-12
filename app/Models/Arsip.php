<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arsip extends Model
{
    use SoftDeletes;
    protected $table = 'arsip';
    protected $fillable = [
        'nomor_arsip', 'judul', 'deskripsi', 'kategori', 'file_path', 'file_name',
        'file_size', 'file_type', 'tanggal_dokumen', 'tahun', 'status',
        'is_rahasia', 'views', 'uploaded_by', 'kegiatan_id',
    ];
    protected $casts = ['tanggal_dokumen' => 'date', 'is_rahasia' => 'boolean'];
    public function uploadedBy() { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function kegiatan() { return $this->belongsTo(Kegiatan::class); }
    public function getFileSizeFormattedAttribute(): string
    {
        $size = $this->file_size;
        if ($size < 1024) return $size . ' B';
        if ($size < 1048576) return round($size / 1024, 1) . ' KB';
        return round($size / 1048576, 1) . ' MB';
    }
}

