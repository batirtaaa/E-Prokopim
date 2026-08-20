<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubKomunikasiPimpinanController extends Controller
{
    public function index()
    {
        return redirect()->route('sambutan.index');
    }
}

