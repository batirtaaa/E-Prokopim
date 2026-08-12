<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanPimpinanController extends Controller
{
    public function index()
    {
        return view('kegiatan-pimpinan.index');
    }

    public function create()
    {
        return view('kegiatan-pimpinan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'lokasi'        => 'required|string',
        ]);

        // TODO: simpan ke database
        return redirect()->route('kegiatan-pimpinan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }
}
