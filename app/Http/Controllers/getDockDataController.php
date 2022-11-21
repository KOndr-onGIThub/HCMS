<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DockCodes;

class getDockDataController extends Controller
{
    public function getDockData(){
        
        $data = dockCodes::all();
//        $data = json_decode($data);
        
        
        return $data;
        
        
    }
}
