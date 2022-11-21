<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class redpostController extends Controller
{
    public function index()
    {
       
        return view('redPost.index');
    }
}
