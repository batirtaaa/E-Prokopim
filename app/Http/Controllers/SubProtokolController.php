<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubProtokolController extends Controller
{
    public function index()
    {
        return view('sub-protokol.index');
    }
}
