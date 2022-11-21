<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\daicoCsv;


class getCsvDaicoDataController extends Controller
{
    public function getCsvDaicoData(){
        
        $data = daicoCsv::all();
//        $data = json_decode($data);
        return $data;
    }

    public static function getCsvDaicoDataLastUpdate(){
        
        if ( daicoCsv::take(1)->exists() ) {
//        dd('existuje');
            $data = daicoCsv::take(1)->get(['csvUpdated'])->toArray();
            return $data[0]['csvUpdated'];
        }else{
//            dd('NE-existuje');
            // jinak vrat fejkovej datum a cas
            return '01.01.1984 01:01:01';
        }
    }
}
