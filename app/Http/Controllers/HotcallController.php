<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotcall;
use App\typeOfMaterial;
use App\placeOfMaterial;
use Illuminate\Validation\ValidationException;
use App\MyUtilities\DateUtils;
use App\CisTablet;



class HotcallController extends Controller
{

    public function index(Hotcall $newInstance)
    {
            //$casHC = $newInstance->mujCas(now());       //'casHC', 'datumHC', nahrazeno s JS
            //$datumHC = $newInstance->mujDatum(now());
        
        $prettyTimes = []; //to avoid exceptions if DB is empty
        $normalTimes = []; //to avoid exceptions if DB is empty
            
        //typ materialu z tabulky type_of_material
        $typeOfMaterials = typeOfMaterial::all();
        //misto materialu z tabulky place_of_material
        $placeOfMaterials = placeOfMaterial::all();            
        //hot cally z tabulky hotcall        
            /* data pro strucnou historii na strance volani */
                //kolik jich tady nactu, tak jen tolik jich mohu pouzit dale ve for cyklu
                $howManyHC = min ( Hotcall::count() , 20); //to avoid exceptions if DB is less than ...
            $calls = Hotcall::orderBy('call_time', 'DESC')->take($howManyHC)->get();

                foreach($calls as $call){
                    $prettyTimes[] = DateUtils::prettyDate( $call->call_time );
                    $normalTimes[] = DateUtils::formatTime( $call->call_time );
                } 
            
            /* list of tablets for select box */
                $listOfTablets = CisTablet::all();
            
              
                
            /* data pro tabulku neukoncene (nofinished) */
            if ( Hotcall::where('hotcall_finished', '=', null)->exists() ) {
                $hotcalls = Hotcall::where('hotcall_finished', '=', null)->orderBy('call_time', 'DESC')->get();
                
                $howManyHCNoFinished = count($hotcalls);

                foreach($hotcalls as $hotcall){
                    $prettyTimesNoFinished[] = DateUtils::prettyDate( $hotcall->call_time );
                    $normalTimesNoFinished[] = DateUtils::formatTime( $hotcall->call_time );
                } 
                
                return view('hotcall.index',compact('hotcalls','calls' , 'listOfTablets' , 'typeOfMaterials', 'placeOfMaterials', 'prettyTimes', 'normalTimes', 'howManyHC', 'howManyHCNoFinished', 'prettyTimesNoFinished', 'normalTimesNoFinished'));
            }else{

                return view('hotcall.index',compact('calls' , 'listOfTablets' , 'typeOfMaterials', 'placeOfMaterials', 'prettyTimes', 'normalTimes', 'howManyHC'));
            }
    }
    

    public function store(Request $request)
    {
        // validate 
        $this->validate($request, [
            'call_time' => ['required' , 'date'],
            'kanban' => ['required', 'min:4', 'max:4'],
            'shift' => ['required', 'min:1', 'max:1'],
            'address' => ['required', 'min:10', 'max:10'],
            'stock_boxes' => ['numeric', 'nullable', 'min:0', 'max:999,99'],
            'stock_pcs' => ['integer', 'nullable', 'min:0', 'max:32767'],
            'stock_min' => ['required', 'integer', 'min:0', 'max:32767'],
            'actual_mros' => ['integer', 'nullable', 'min:0', 'max:99'],
            'plan_mros' => ['integer', 'nullable', 'min:0', 'max:99'],
            'note_to_write' => ['min:0', 'max:100'],
            'boxes_for_delivery' => ['required', 'integer', 'min:0', 'max:99'],
//            'boxes_delivered' => ['integer', 'min:0', 'max:32767'],
//            'boxes_before_delivery' => ['integer', 'min:0', 'max:32767'],
            'delivery_boy' => ['nullable', 'min:0', 'max:20'],
            'kbr_user' => ['required', 'integer'],
//            'tablet' => ['integer', 'nullable'],
            'status_tablet' => ['integer', 'min:0', 'max:32767'],
            'sent_to_tablet' => ['date'],
            'tablet_accepted' => ['date'],
            'tablet_done' => ['date'],
//            'hotcall_finished' => ['date'],
            
            'part_name' => ['max:60'],
            'part_number' => ['max:14'],
            
            'supplier_code' => ['max:6'],
            'supplier_name' => ['max:50'],
            'dock_code' => ['max:2'],
            'box_type' => ['max:4'],
            'course_stocker' => ['max:2'],
            'course_picker' => ['max:2'],
            'course_deliver' => ['max:2'],
            'address_store' => ['max:10'],
            'box_lot' => ['integer', 'nullable'],
            'line_side_capacity_requested' => ['integer', 'nullable', 'min:0', 'max:32767'],
            'line_side_capacity_real' => ['numeric', 'nullable', 'min:0', 'max:32767'],
            'safety_boxes_line_side' => ['integer', 'nullable', 'min:0', 'max:32767'],
            'safety_boxes_pc_store' => ['integer', 'nullable', 'min:0', 'max:32767'],
            'hc_level' => ['integer', 'nullable', 'min:0', 'max:32767'],
            'specialist_pc' => ['max:2', 'nullable'],
            'build_out_yes_no' => ['integer', 'nullable', 'min:0', 'max:1'],
//            'build_out_date' => ['date', 'nullable'],
//            'build_out_target' => ['integer', 'nullable', 'min:0', 'max:32767'],
//            'ovf_yes_no' => ['integer', 'nullable', 'min:0', 'max:1'],
            'ovf_zone' => ['min:0', 'max:500', 'nullable'],
            'ovf_number_of_boxes' => ['integer', 'nullable'],
            'ovf_number_of_boxes_cut_area' => ['integer', 'nullable'],
            'ovf_detailList' => ['min:0', 'max:700', 'nullable'],
            'divert_yes_no' => ['integer', 'nullable', 'min:0', 'max:1'],
            'divert_problem_description' => ['min:0', 'max:150'],
            'divert_instead_of_control' => ['min:0', 'max:30'],
            'divert_implementatio_by' => ['min:0', 'max:30'],
            'kind_of_hc' => ['required', 'min:0', 'max:20'],
            'type_of_material' => ['min:0', 'max:20'],
            'place_of_material' => ['min:0', 'max:20'],
            'multiAddresses' => ['min:0', 'max:500'],
            'boxUsage' => ['min:0', 'max:9'],
        ]);
    
    
        $hotcall = new Hotcall();
            $hotcall->call_time = request('call_time');
            $hotcall->kanban = request('kanban');
            $hotcall->shift = request('shift');
            $hotcall->address = request('address');
            $hotcall->stock_boxes = request('stock_boxes');
            $hotcall->stock_pcs = request('stock_pcs');
            $hotcall->stock_min = request('stock_min');
            $hotcall->actual_mros = request('actual_mros');
            $hotcall->plan_mros = request('plan_mros');
            $hotcall->note_to_write = request('note_to_write');
            $hotcall->boxes_for_delivery = request('boxes_for_delivery');
//            $hotcall->boxes_delivered = request('boxes_delivered');
//            $hotcall->boxes_before_delivery = request('boxes_before_delivery');
            if(request('whom_1') != 'TABLET'){
                $hotcall->delivery_boy = request('whom_1');
            }else{
                $hotcall->delivery_boy = request('delivery_boy');
            };
            $hotcall->kbr_user = request('kbr_user');
//            $hotcall->tablet = request('tablet');
            $hotcall->status_tablet = 1;
            $hotcall->sent_to_tablet = now();
            $hotcall->tablet_accepted = request('tablet_accepted');
            $hotcall->tablet_done = request('tablet_done');
//            $hotcall->hotcall_finished = request('hotcall_finished');
            
            $hotcall->part_name = request('part_name');
            $hotcall->part_number = request('part_number');
            
            $hotcall->supplier_code = request('supplier_code');
            $hotcall->supplier_name = request('supplier_name');
            $hotcall->dock_code = request('dock_code');
            $hotcall->box_type = request('box_type');
            $hotcall->course_stocker = request('course_stocker');
            $hotcall->course_picker = request('course_picker');
            $hotcall->course_deliver = request('course_deliver');
            $hotcall->address_store = request('address_store');
            $hotcall->box_lot = request('box_lot');
            $hotcall->line_side_capacity_requested = request('line_side_capacity_requested');
            $hotcall->line_side_capacity_real = request('line_side_capacity_real');
            $hotcall->safety_boxes_line_side = request('safety_boxes_line_side');
            $hotcall->safety_boxes_pc_store = request('safety_boxes_pc_store');
            $hotcall->hc_level = request('hc_level');
            $hotcall->specialist_pc = request('specialist_pc');
            $hotcall->build_out_yes_no = request('build_out_yes_no');
//            $hotcall->build_out_date = request('build_out_date');
//            $hotcall->build_out_target = request('build_out_target');
//            $hotcall->ovf_yes_no = request('ovf_yes_no');
            $hotcall->ovf_zone = request('ovf_zone');
            $hotcall->ovf_number_of_boxes = request('ovf_number_of_boxes');
            $hotcall->ovf_number_of_boxes_cut_area = request('ovf_number_of_boxes_cut_area');
            $hotcall->ovf_detailList = request('ovf_detailList');
            $hotcall->divert_yes_no = request('divert_yes_no');
            $hotcall->divert_problem_description = request('divert_problem_description');
            $hotcall->divert_instead_of_control = request('divert_instead_of_control');
            $hotcall->divert_implementatio_by = request('divert_implementatio_by');
            $hotcall->kind_of_hc = request('kind_of_hc');
            $hotcall->type_of_material = request('type_of_material');
            $hotcall->place_of_material = request('place_of_material');
            $hotcall->multiAddresses = request('multiAddresses');
            $hotcall->boxUsage = request('boxUsage');
            $hotcall->list_of_models = request('list_of_models');
        $hotcall->save();
        
        return redirect('/Hotcall');

         
    }
    
    
    // NESTASTNE POJMENOVANO - SLOUZI K OZNACENI HC JAKO UKONCENEHO
    public function update($id, $time){
            
        $hotcallUpdated = Hotcall::find($id);
        
        $hotcallUpdated->hotcall_finished = $time;

        $hotcallUpdated->save();
        
        return redirect('/Hotcall');
    }
    

    //nacte data z DB a předá je
    public function loadToUpdate($id)
    {
        $loadToUpdate = Hotcall::find($id);
    
        return $loadToUpdate;
    }

    // TOTO JE PRO UPDATE INFORMACI
    public function updateINFO(Request $request){
        
        $data = $request->all();
        
        

        //validate 
//$validated = $request->validate([
//            'call_time' => ['required' , 'date'],
//            'kanban' => ['required', 'min:4', 'max:4'],
//            'shift' => ['required', 'min:1', 'max:1'],
//            'address' => ['required', 'min:10', 'max:10'],
//            'stock_boxes' => ['numeric', 'nullable', 'min:0', 'max:999,99'],
//            'stock_pcs' => ['integer', 'nullable', 'min:0', 'max:32767'],
//            'stock_min' => ['required', 'integer', 'min:0', 'max:32767'],
//            'actual_mros' => ['integer', 'nullable', 'min:0', 'max:99'],
//            'plan_mros' => ['integer', 'nullable', 'min:0', 'max:99'],
//            'note_to_write' => ['min:0', 'max:100'],
//            'boxes_for_delivery' => ['required', 'integer', 'min:0', 'max:99'],
//            'delivery_boy' => ['nullable', 'min:0', 'max:20'],
//    ]);

            $id = $data['idOfHC'];             
        $hotcallUpdatedINFO = Hotcall::find($id);
     
            $hotcallUpdatedINFO->shift = $data['shift'];
            $hotcallUpdatedINFO->address = $data['address'];
            $hotcallUpdatedINFO->stock_boxes = $data['stock_boxes'];
            $hotcallUpdatedINFO->stock_pcs = $data['stock_pcs'];
            $hotcallUpdatedINFO->stock_min = $data['stock_min'];
            $hotcallUpdatedINFO->actual_mros = $data['actual_mros'];
            $hotcallUpdatedINFO->plan_mros = $data['plan_mros'];
            $hotcallUpdatedINFO->note_to_write = $data['note_to_write'];
            $hotcallUpdatedINFO->boxes_for_delivery = $data['boxes_for_delivery'];
            $hotcallUpdatedINFO->kind_of_hc = $data['kind_of_hc'];
            if($data['whom_1'] != 'TABLET'){
                $hotcallUpdatedINFO->delivery_boy = $data['whom_1'];
            }else{
                $hotcallUpdatedINFO->delivery_boy = $data['delivery_boy'];
            };
        $hotcallUpdatedINFO->save();

        return response()->json(['success'=>'Ajax request submitted successfully']);


    }
    
    // pro to aby JS pomoci ajaxu zjistil jestli uz ne/byl HC ukoncen (HotcallController.php & actionsTime.js & ajax_data.js)
    public function data(){
        $data = Hotcall::where('hotcall_finished', '<>', null)->orderBy('hotcall_finished', 'DESC')->limit(10000)->get();
        return $data;
    }
    
    
}


