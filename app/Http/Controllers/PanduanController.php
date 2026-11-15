<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;

class PanduanController extends Controller
{
    /**
     * Tampilkan halaman Buku Panduan Penggunaan Sistem E-PROKOPIM.
     */
    public function index()
    {
        $instansi = Instansi::first();

        return view('panduan.index', compact('instansi'));
    }
}
