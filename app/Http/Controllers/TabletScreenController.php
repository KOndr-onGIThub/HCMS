<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotcall;
use App\CisTablet;
use App\MyUtilities\DateUtils;
use Log;

class TabletScreenController extends Controller
{
    
    public function tabletSelection(){
            
            //get list of tablets from DB
            $tabletsList = CisTablet::get();
        
            return view('tablet.tabletSelection',compact('tabletsList'));

    }
    
    public function index($tabletName){
            // initialization
            $notFinished = 'no';
            $Finished = 'no';
            $hotcalls = array();
            $lastHotcalls = array();
            
            //get list of tablets from DB
            $tabletsList = CisTablet::get();
        

            /* data neukoncenych HC */
            if ( Hotcall::where('hotcall_finished', '=', null)->where('delivery_boy', '=', $tabletName)->exists() ) {
                $lastHC_ID = Hotcall::latest('id')->first('id'); // to recognize if new HC
                $hotcalls = Hotcall::where('hotcall_finished', '=', null)->where('delivery_boy', '=', $tabletName)->orderBy('call_time', 'DESC')->get();

                $howManyHCNoFinished = count($hotcalls);

                foreach($hotcalls as $hotcall){
                    $prettyTimesNoFinished[] = DateUtils::prettyDate( $hotcall->call_time );
                    $normalTimesNoFinished[] = DateUtils::formatTime( $hotcall->call_time );
                }
                $howManyHCNoFinished>0 ? $notFinished = 'yes' : '';
            }

            /* data poslednich ukoncenych HC */
            if ( Hotcall::where('hotcall_finished', '<>', null)->where('delivery_boy', '=', $tabletName)->exists() ) {
                $lastHotcalls = Hotcall::where('hotcall_finished', '<>', null)->where('delivery_boy', '=', $tabletName)->orderBy('hotcall_finished', 'DESC')->limit(3)->get();


                foreach($lastHotcalls as $lastHotcall){
                    $prettyTimesTablet_done[] = DateUtils::prettyDate( $lastHotcall->hotcall_finished );
                    $normalTimesTablet_done[] = DateUtils::formatTime( $lastHotcall->hotcall_finished );
                }
                count($lastHotcalls)>0 ? $Finished = 'yes' : '';
            }

                        
                if($notFinished === 'yes' and $Finished === 'yes'){
                    return view('tablet.tabletScreen' ,compact('tabletName', 'tabletsList', 'lastHC_ID', 'hotcalls', 'howManyHCNoFinished', 'prettyTimesNoFinished', 'normalTimesNoFinished', 'lastHotcalls', 'prettyTimesTablet_done', 'normalTimesTablet_done'));
                }elseif($notFinished == 'yes'){
                    return view('tablet.tabletScreen',compact('tabletName', 'lastHC_ID', 'hotcalls', 'howManyHCNoFinished', 'prettyTimesNoFinished', 'normalTimesNoFinished'));
                }elseif($Finished == 'yes'){
                    return view('tablet.tabletScreen',compact('tabletName', 'lastHotcalls', 'prettyTimesTablet_done', 'normalTimesTablet_done'));
                }else{
                    return view('tablet.tabletScreen',compact('tabletName'));
                }
    }

    public function status($id, $status, $time, $delivered, $remaining){

        $hotcallUpdated = Hotcall::find($id);

        $hotcallUpdated->status_tablet = $status;

        switch($status){
            case '2':
                $hotcallUpdated->tablet_accepted = $time;
                break;
            case '3':
                $hotcallUpdated->tablet_done = $time;
                $hotcallUpdated->hotcall_finished = $time;
                $hotcallUpdated->boxes_delivered = $delivered;
                $hotcallUpdated->boxes_before_delivery = $remaining;
                break;
            default:
        }

        $hotcallUpdated->save();

        return redirect('/TabletScreen');

    }




}
