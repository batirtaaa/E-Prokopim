<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubDokumentasiPimpinanController extends Controller
{
    public function index()
    {
        return view('sub-dokumentasi-pimpinan.index');
    }
}
