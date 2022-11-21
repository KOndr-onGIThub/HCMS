<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class divertController extends Controller
{
    public function index()
    {
       
        return view('divert.index');
    }
}
