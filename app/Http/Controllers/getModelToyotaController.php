<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelToyota;

class getModelToyotaController extends Controller
{
    public function getModelToyota(){
        
        $data = ModelToyota::all();
//        $data = json_decode($data);
        
        
        return $data;
        
        
    }
}
