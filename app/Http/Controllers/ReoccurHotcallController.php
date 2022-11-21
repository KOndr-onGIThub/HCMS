<?php

namespace App\Http\Controllers;

use App\Hotcall;


class ReoccurHotcallController extends Controller
{
    //kontrola, zda existuje HC, ktery jeste neni ukoncen na stejny kanban
    public function reoccurHotcall($kbn)
    {

            if (  Hotcall::where('hotcall_finished', '=', null)->where('kanban', '=', $kbn)->exists() ) {
//                $reHC = Hotcall::where('hotcall_finished', '=', null)->where('kanban', '=', $kbn)->first();
                return [0=> 'YES'];
            }else{
                return [0=> 'NO'];
            }
    }
}