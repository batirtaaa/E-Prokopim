<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use SoftDeletes;
    protected $table = 'laporan';
    protected $fillable = ['judul', 'deskripsi', 'tipe', 'periode_mulai', 'periode_selesai', 'file_laporan', 'status', 'created_by'];
    protected $casts = ['periode_mulai' => 'date', 'periode_selesai' => 'date'];
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
}
