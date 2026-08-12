<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubKomunikasiPimpinanController extends Controller
{
    public function index()
    {
        return view('sub-komunikasi-pimpinan.index');
    }
}
