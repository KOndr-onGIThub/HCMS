function data_NG_parts(kanban, kbnChanged, index){
var API_getPartByKanban = $('#API_getPartByKanban').val();

 $.ajax({
    url: API_getPartByKanban +kanban+'/hotcall_management',
    dataType: "json",
    method: 'get',
    success: function (data, sCode, sPlant) {
         //console.log(data.length);

        if( (data != 'null') && (data != '') ){
            
            if(kbnChanged == 'YES'){
                getListOfVariants(data);
//                getListOfModels(data);
            }else{
                getBasicInfo(data, index);
            };

                var sCode = data[0]['supplier info']['supplier code'];
                var sPlant = data[0]['supplier info']['plant code'];

                //////////ADRESY
    //                            getAddresses(data); // adresy budu brat z aplikace Divert - ILSS

                data_divert_Divert(sCode, sPlant); // volani dalsiho ajaxu (z tohoto ajaxu totiz beru data)
                DockData();

        }else{
                alert('Nepodarilo se nacist data z aplikace "NG parts". \nZkontroluj KBN číslo: ' + kanban + ' \n\n err.2');
                clearDestroy2('refresh');
        };   
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "NG parts". \nZkontroluj KBN číslo. \n\n err.1');
        clearDestroy2('refresh');
    }
});
}


                    //function getAddresses(data){
                    //    var  cil = $('#tbody_adresy_zasoby');
                    //    for(var polozka in data['address info']) {
                    //        cil.append('<tr><td>' + data['address info'][polozka]['address'] + '</td></tr>' );
                    //    };
                    //}
                    
//fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
                    function getListOfVariants(data){
                        var partsVariant = data.length;
                        var selectBoxOfVariant = '<select id="selectBoxOfVariant" class="saved destroy">';
                        var howManyActivVariants = 0; //default
                        var theSmallestActeveIndex = 999; //default - vyznam je, aby takový index neexistoval a nezobrazili se tak žádné udaje, pokud ovšem budou další podmínky splněny, toto se přepíše
                        
                        
                        if(partsVariant > 0){
                            for(let polozka in data) {

                                if(data[polozka]['basic info']['status'] == 1){
                                    howManyActivVariants ++;

                                    theSmallestActeveIndex = Math.min(polozka, theSmallestActeveIndex);
                                    
                                    selectBoxOfVariant += ' <option value="' + polozka + '" > Varianta '+ polozka + ' </option>';
                                    
                                };
                            };
                            
                            selectBoxOfVariant += '</select>';
                            
                            if(howManyActivVariants <2 ){
                                selectBoxOfVariant = ''; // because if there is more than 1 variant but only 1 has active status 1 ...
                            };
                                
                                
                            $('#partVariant').html( selectBoxOfVariant );
                            localStorage.selectBoxOfVariant=selectBoxOfVariant;
                        }else{
                            // because when user changes KBN from part which has more variants to part with 1 var., I need to clear this select box
                            localStorage.selectBoxOfVariant='';
                            $('#partVariant').html('');
                            
                        };
                        
                            getBasicInfo(data, theSmallestActeveIndex);
                        
                    }
                    
//fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
$(document).ready(function(){
    var kanban=$('#kanban');
    
        $('#partVariant').change(function(){
            var partsVariant = $('#partVariant select').children("option:selected").val();
            var kbnChanged = 'NO';
            data_NG_parts(kanban.val(), kbnChanged, partsVariant);
        });
});

                        
//fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
                    function getBasicInfo(data, partsVariant){
                        
                        let partName = data[partsVariant]['basic info']['part name']; // zjisti hodnotu a uloz do promenne 
                        $('#partName').val(partName); // zabraz ji
                        localStorage.partName=partName; // uloz do local storage, pro pripad opusteni stranky apod.

                        let tenDigit = data[partsVariant]['basic info']['part number'];
                        let sfx = data[partsVariant]['basic info']['color sfx'];
                        let pn = tenDigit.substring(0,5) + '-' + tenDigit.substring(5,10) + '-' + sfx;
                        $('#partNumber').val(pn);
                        localStorage.partNumber=pn;

                        let name = data[partsVariant]['supplier info']['name'];
                        $('#supplierName').val(name);
                        localStorage.supplierName=name;

                        var sCode = data[partsVariant]['supplier info']['supplier code'];
                        var sPlant = data[partsVariant]['supplier info']['plant code'];
                        let supplierCode = sCode + '-' + sPlant;
                        $('#supplierCode').val(supplierCode);
                        localStorage.supplierCode=supplierCode;

                        let dock = data[partsVariant]['basic info']['dock'];
                        $('#dockCode').val(dock);
                        localStorage.dockCode=dock;

                        let pCode = 'XX';  // now not used
                        $('#paletizationCode').val(pCode);
                        localStorage.paletizationCode=pCode;

                        let boxType = data[partsVariant]['basic info']['box type'];
                        $('#boxType').val(boxType);
                        localStorage.boxType=boxType;

                        let boxLot = data[partsVariant]['basic info']['box lot'];
                        $('#boxLot').val(boxLot);
                        localStorage.boxLot=boxLot;

                        let specialist = data[partsVariant]['basic info']['pc specialist'];
                        $('#specialistCode').val(specialist);
                        localStorage.specialistCode=specialist;
// build_out_date nahrazeno build_out_ode
//                        let build_out_date = data[partsVariant]['basic info']['bo date'];
//                        let build_out_yes_no = 0;
//                        if(build_out_date.length === 8 ){
//                            build_out_date = build_out_date.substring(0,4) + '-' + build_out_date.substring(4,6) + '-' + build_out_date.substring(6,8);
//                            build_out_yes_no = 1;
//                        }else{
//                            build_out_date = '';
//                            build_out_yes_no = 0;
//                        }
//                        $('#build_out_date').val(build_out_date);
//                        $('#build_out_yes_no').val(build_out_yes_no);
//                        localStorage.build_out_date=build_out_date;
//                        localStorage.build_out_yes_no=build_out_yes_no;
                        let build_out_code = data[partsVariant]['basic info']['sop cond'];
                        let build_out_yes_no = 0;
                        (build_out_code.length > 0 ) ? build_out_yes_no = 1 : '';
                        
                        $('#build_out_code').val(build_out_code);
                        $('#build_out_yes_no').val(build_out_yes_no);
                        localStorage.build_out_code=build_out_code;
                        localStorage.build_out_yes_no=build_out_yes_no;
                        
                        
//                        let modelToyotaCode = data[partsVariant]['basic info']['mf vehicle code'];
//                        let url = $('#getModelToyota').val();
//                        func_ajax_modelToyota(url, modelToyotaCode);

                        let url = $('#getCsvPartrqdbData').val() + '/' + tenDigit + sfx;
                        func_ajax_models(url);

                    }

//fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
////to get list of models of the kanban number for saving to DB history
//function getListOfModels(data){
//        var listOfmodelCodes = [];
//
//        for(let polozka in data) {
//            if(data[polozka]['basic info']['status'] == 1){
//                listOfmodelCodes.push( data[polozka]['basic info']['mf vehicle code'] );
//            };
//        };
//        
//        let url = $('#getModelToyota').val();
//        func_ajax_AllModelsToyota(url, listOfmodelCodes)
//
//}


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function data_NG_parts_divert(id){
var API_getDivert = $('#API_getDivert').val();

 $.ajax({
    url: API_getDivert + id +'/hotcall_management',
    dataType: "json",
    method: 'get',
    success: function (data) {

        getDivertDetails(data, id);

    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "NG parts" (data_NG_parts_divert). \n\n err.1');
        clearDestroy2('refresh');
    }
});
}

                    function getDivertDetails(data){
                        let who = data['responsibility'];
                        let where = data['sorting_place'];
                        let what = data['problem_description'];
                        
                        $('#divert_implementatio_by').val(who);
                        $('#divert_instead_of_control').val(where);
                        $('#divert_problem_description').val(what);
                        
                    }