function func_ajax_models(url){
 $.ajax({
    url: url ,
    dataType: "json",
    method: 'get',
    success: function (modelToyotaCode) {
        if(modelToyotaCode !== '') {
            let urlGetModelToyota = $('#getModelToyota').val();
            func_ajax_modelToyota(urlGetModelToyota, modelToyotaCode);
        };       
    },
    error: function(){
        alert('Nepodarilo se nacist data z ajax_modelToyota.js. \n\n err.1'); 
    }
});
}


// ajax zavola vlastni API k zjistení modelu auta dle kodu ziskaneho v ajax_NGparts.js -> ZMENA NA PARTRQDB
function func_ajax_modelToyota(urlGetModelToyota, modelToyotaCode){
 $.ajax({
    url: urlGetModelToyota,
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);

        if(data != '') {
            let modelInput = $('#modelToyota');
            //defaul values
            let modelToyota = '? ? ?';
            let bckgColor = 'yellow';
            let title = "Žadný z kódů nalezených v PARTRQDB neznám. Obrať se na admina.";

            let yaris = 0; // 0 means no Yaris
            let aygo = 0; // 0 menas no Aygo
            let vehicle= '';
            
            
            for(let oneModel in modelToyotaCode){
                for(let polozka in data) {
                
                    if(data[polozka]['code'] == modelToyotaCode[oneModel]['MODEL']){

                        bckgColor = data[polozka]['color_in_app'];
                        title = 'Tento model auta byl přiřazen na základě souboru PARTRQDB.';
                        
                        switch (data[polozka]['vehicle']) {
                          case 'Yaris':
                                yaris = 1;
                            break;
                          case 'Aygo':
                                aygo = 1;
                            break;
                          default:
                               alert( 'Informujte administratora aplikace o teto chybe. V PARTRQDB byl nalezen modelovy kod jenz neni definovan v DB tabulce model kodu. ' + modelToyotaCode[oneModel]['MODEL']  );
                            break;
                        };    
                    }
                }
            };

            switch (yaris + aygo) {
              case 2:
                    vehicle='Aygo&Yaris';
                    bckgColor = 'pink';
                break;
              case 1:
                    aygo > yaris ? vehicle='Aygo' : vehicle='Yaris';
                break;
            };  
                    modelInput.val(vehicle);
                    modelInput.css('background', bckgColor);
                    modelInput.attr('title', title);
                    $('#listOfmodels').val(vehicle);

                    saveIt(modelInput, bckgColor, title, vehicle);
        };
    },
    error: function(){
        alert('Nepodarilo se nacist data z ajax_modelToyota.js. \n\n err.2');
    }
});
}
function saveIt(modelInput, bckgColor, title, vehicle){
localStorage.modelToyota=modelInput.val();
localStorage.modelToyotaColor=bckgColor;
localStorage.modelToyotaTitle=title;
localStorage.listOfmodels=vehicle;
}


// pro zjisten vsech modelovych variant daného kanbanového cisla -> PREDELANO NA PARTRQDB
//function func_ajax_AllModelsToyota(url, listOfmodelCodes){
// $.ajax({
//    url: url,
//    dataType: "json",
//    method: 'get',
//    success: function (data) {
////         console.log(data);
//
//        if(data != '') {
//            let yaris = 0; // 0 means no Yaris
//            let aygo = 0; // 0 menas no Aygo
//            let undefinedVehicle = '';
//            let vehicle= '';
//            
//            for(let polozka in data) {
//                for(let polozka2 in listOfmodelCodes) {
//                    
//                    if(data[polozka]['code'] === listOfmodelCodes[polozka2]){
//                        
//                        switch (data[polozka]['vehicle']) {
//                          case 'Yaris':
//                                yaris = 1;
//                            break;
//                          case 'Aygo':
//                                aygo = 1;
//                            break;
//                          default:
//                              undefinedVehicle += '+"undfn:' + listOfmodelCodes[polozka2] + '"';
//                            break;
//                        };                        
//                    }; 
//                };
//            };
//
//            switch (yaris + aygo) {
//              case 2:
//                    vehicle='Aygo&Yaris';
//                break;
//              case 1:
//                    aygo > yaris ? vehicle='Aygo' : vehicle='Yaris';
//                break;
//            };  
//            
//            vehicle += undefinedVehicle; // TO ADD IF SOME UNDEFINDED VEHICLE CODE IS THERE
//                        
//            vehicle.length >50 ? vehicle = vehicle.substr(0,46) + '...' : '';  //validation for DB (max 50 char.)
//            
//            $('#listOfmodels').val(vehicle);
//            localStorage.listOfmodels=vehicle;
//
//        };
//                
//         
//    },
//
//    error: function(){
//        alert('Nepodarilo se nacist data z ajax_modelToyota.js. \n\n err.2');
//    }
//});
//}