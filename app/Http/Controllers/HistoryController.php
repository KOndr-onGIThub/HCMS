<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotcall;
use Yajra\DataTables\DataTables;


class HistoryController extends Controller
{
//    public function index(Hotcall $newInstance)
//    {
//        $howManyRows = 2000;
//        
//        $hotcalls = Hotcall::orderBy('call_time', 'DESC')->take($howManyRows)->get();
//        return view('history.index', compact('hotcalls', 'howManyRows'));
//    }
    
    /*
     * Metoda pro volání dat do Datatable v reřimu ServerSide
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $hotcalls = Hotcall::select('*');
            return Datatables::of($hotcalls)->make(true);
         }

        return view('history.index');
    }

}
