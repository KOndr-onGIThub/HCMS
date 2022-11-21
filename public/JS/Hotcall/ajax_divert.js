//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function data_divert_OrderSummary(kanban){
var API_getOrderSummaryData = $('#API_getOrderSummaryData').val();
    
 $.ajax({
    url: API_getOrderSummaryData + kanban + '&application=hotcall',
    dataType: "json",
    method: 'get',
    success: function (data) {
         //console.log(data);

        if((data != 'null') && (data != '')){
            getOrderSummary(data);
        }else{
            $('#tbody_order_summary').html('<td>ŽÁDNÁ DATA</td>');
        } 
                
            saveOrderSummTable();  // ulozit az budou vsechny data co potrebuju v teto tabulce nacteny
         

    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Divert - Order Summary". \nZkontroluj KBN číslo. \n\n err.1');
        clearDestroy2('refresh');
    }
});
}


                        
                    function getOrderSummary(data){
                        let polozka; // polozka pro cyklus
                        let manifArr = []; // pole s hodnotami pro serazeni a dalsi manipulaci
                        let YYYY = $('#OrdSumm_year').val();
                            YYYY.length < 4 ? YYYY = new Date().getFullYear() : ''; // pokud nezadam 4 znaky roku, tak vem aktualni rok
                        let MM = $('#OrdSumm_month').val();
                            MM.length == 1 ? MM = '0'+MM : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
                        let DD = $('#OrdSumm_day').val();
                            DD.length == 1 ? DD = '0'+DD : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
                        let YYYYMMDD = YYYY + MM + DD;
                        let MROS = $('#actual_mros').val();
                            MROS.length == 1 ? MROS = '0'+MROS : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku), aby to bylo stejne jako prijata data
                        let YYYYMMDD_MROS = YYYYMMDD + MROS; // seskupeno kvuli pozdejsimu nalezeni spravnych hodnot k zobrazeni
                        let manifPlusMros; // sem si ulozim polozky pole v cyklu
                        let row1 = '<td>MANIF.</td>'; // prvni radek tabulky
                        let row2 = '<td>MROS</td>'; // druhy radek tabulky
                        let row3 = '<td>BOXŮ</td>'; // treti radek tabulky
                        let item = ''; //pro prehlednejsi maipulaci s casti pole
                        let column = 0; // prvni sloupec tabulky
                        let numberOfColumns = 6; // kolik sloupcu tabulka bude mit
                        
                        // protoze struktura pole data neumoznuje seradit, tak si nejprve naplnim sve pole ...
                        for(let polozka in data) {
                            manifArr.push( data[polozka]['manifest'] + data[polozka]['mros'] + data[polozka]['ordered box'] );
                        }
                        // seradim ...
                        manifArr.sort();

                        // PROJEDU POLE A NAPLNIM SI SLOUPCE JEDNOTLIVYCH RADKU
                        for(let polozka in manifArr) {
                            
                            manifPlusMros = manifArr[polozka].substring(0, 8) +  manifArr[polozka].substring(10, 12);
                            
                            // SLOUPCE RESP. RADKY TVORIM JE Z DAT DLE PODMINKY
                            if ( (manifPlusMros >= YYYYMMDD_MROS) && (column < numberOfColumns) ){
                                
                                    item = manifArr[(manifArr.length===1) ? polozka : polozka -1 ]; // minus jedna, protoze me zajima posledni predchozi dodavka a pak X dalsich, pokud je pole dost dlouhe of course
                                    
                                    row1 += '<td class="OrderSummColumn' + column + '"><span class="OrderSummYear">' + item.substring(0, 4) + '</span>' + 
                                                '<span class="OrderSummMonth">' + item.substring(4, 6) + '</span>' +
                                                '<span class="OrderSummDay">' + item.substring(6, 8) + '</span>' + 
                                            '<span class="OrderSummSequence">' + item.substring(8, 10) + '</span></td>' ;
                                    row2 += '<td class="OrderSummColumn' + column + '"><span class="OrderSummMros">' + item.substring(10, 12) + '</span></td>' ;
                                    row3 += '<td class="OrderSummColumn' + column + '"><span class="OrderSummBox">' + item.substring(12, 99) + '</span></td>' ;
                            
                            column++; // pocitam si sloupce abych je omezil
                            }
                        }
                        
                        //vypis sestavenou tabulku
                        $('#tbody_order_summary').html('<tr>' + row1 + '</tr><tr>' + row2 + '</tr><tr>' + row3 + '</tr>');
                        
                    }
                    
                    //ulozi html kod casti stranky - tabulky
                    function saveOrderSummTable(){
                        localStorage.orderSummTable_content = $('#tbody_order_summary').html();
                    }



//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function data_divert_Divert(sCode, sPlant){
var API_getDivertData = $('#API_getDivertData').val();

 $.ajax({
    url: API_getDivertData,
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);

        getDivertCondition(data, sCode, sPlant);
        
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Divert" - getDivertData. \n\n err.1');
        clearDestroy2('refresh');
    }
});
}

                    function getDivertCondition(data, sCode, sPlant){
                        // pokud v seznamu bude alespon jednou danny kanban resp. dodavatel, tak se hodnota promnene zmeni a na ni pak reaguji
                        var divertKBN = 'N';
                        var divertSupplier = 'N';
                        var idDivert = 0;
                    for(let polozka in data) {
                            // 
                            
                            
                            if( data[polozka]['kanban'] == $('#kanban').val() ){
                                divertKBN = 'Y';
                                divertSupplier = 'Y';
                                idDivert = data[polozka]['id'];
                            }else if( data[polozka]['supplier'] == (sCode + sPlant) ){
                                divertSupplier = 'Y';
                                idDivert = data[polozka]['id'];
                            }        
                        };
                        
                        if(divertKBN == 'Y'){
                            divertKBN ='<span class="divert">DÍL ANO</span><input hidden ID="divert_yes_no" type="text" name="divert_yes_no" value="1"> ';
                        }else{
                            divertKBN =('<span class="divertNO">DÍL NE</span><input hidden ID="divert_yes_no" type="text" name="divert_yes_no" value="0"> ');
                        } 
                        if(divertSupplier == 'Y'){
                            divertSupplier =('<span class="divert">DODAVATEL ANO</span> ');
                        }else{
                            divertSupplier =('<span class="divertNO">DODAVATEL NE</span> ');
                        }
                        //vlozit prislusny span do html a localstorage
                        $('#divert_part').html(divertKBN);
                        localStorage.divert_part=divertKBN;
                        $('#divert_supplier').html(divertSupplier);
                        localStorage.divert_supplier=divertSupplier;
                        $('#divert_id').html(idDivert);
                        localStorage.divert_id=idDivert;
                        
                        if(idDivert !== 0){
       
                        data_NG_parts_divert(idDivert);
                        }
                        
                    }
                    


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function data_divert_ILSS(kanban, dockType, dockLookedFor){ 
var API_getDaicoData = $('#API_getDaicoData').val();
 
 $.ajax({
    url: API_getDaicoData + kanban + '&application=hotcall',
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);
        // for case when address in system is not the real one - we have to have possibility create that hotcall - we can write the addres into inputbox for notes
        let anotherAddress = '<option value="jinaAdresa">jiná adresa</option>';

        if((data != 'null') && (data != '')){
             

            // podle docku urcim jaky typ adresy budu hledat
            let addresType = (dockType == 'PC-Store' ? 'ika' : 'kpa');
                        
            getAddresses(data, addresType, dockLookedFor, anotherAddress);
            getCourses(data, addresType);

        }else{
            
            $('#tbody_adresy_zasoby').html('<tr><td colspan="9">ŽÁDNÉ DATA Z API APLIKACE PALET DIVERT (getDaicoData), TZN. ŽÁDNÉ ADRESY ATD.</td></tr>');
            $('#address').html(anotherAddress);
        }
        
        CsvDaicoData(kanban, dockType); //because info from daico depends on addresses, I call it here
        
        
        saveAddressTable();  // ulozit az budou vsechny data co potrebuju v teto tabulce nacteny
        
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Divert - ILSS". \nZkontroluj KBN číslo. \n\n err.1');
        clearDestroy2('refresh');
    }
});
}

                    function getAddresses(data, addresType, dockLookedFor, anotherAddress){
                        let cil_1 = $('#tbody_adresy_zasoby');
                        let cil_2 = $('#address');
                        let cil_3 = $('#multiAddresses');
                        let thisArray = [];
                        let thisArraySorted = [];
                        let pc_store;
                        let multiAddressList = '';
                        // protoze struktura pole data neumoznuje srovnat adresy, tak si nejprve adresami naplnim sve pole ...
                        for(let polozka in data) {


                        let TC = $('#ADR_year').val() + $('#ADR_month').val() + $('#ADR_day').val();
                        //console.log(TC);
                            if( (data[polozka]['date from'] <= TC) && (data[polozka]['date to'] >= TC) && data[polozka][addresType] !== null){
                            
                                  thisArray.push(data[polozka][addresType]);
                                  
                                if(dockLookedFor == data[polozka]['dock']){ // need to check dock code, because 1 part could be PC-store parts for 1 dock and Direct parts for another dock
                                      pc_store = data[polozka]['kpa']; // the last one is enough because of PC-store address must be only one
                                  }
                            }
                        };
                        
                        
                        // seradim ...
                        thisArray.sort();

                        // remove duplicates
                        $.each(thisArray, function(i, el){
                            if($.inArray(el, thisArraySorted) === -1) thisArraySorted.push(el);
                        });

                        // serazene adresy si doplnim o HTML ...
                        var addresesTable ='';
                        var addresesSelect = ['<option value=" "></option>']; // prvni je prazdny, abych adresu musel vybrat a fungoval tak JS actionAddress

                        if(thisArraySorted.length > 0 ){
                            for(let polozka in thisArraySorted) {
                                let idAddress = thisArraySorted[polozka];
                               
                                    if(idAddress !== null){ // pokud bych nemel tuto podminku, tak by selhala funkce replace
                                
                                        multiAddressList += idAddress.replace(/ /g, '') + ', '; //especialy for detail table on tablet screen, jo a odebiram mezery
                                
                                        idAddress = idAddress.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID
                                    }
                                addresesTable +=  '<tr id="rowAddres_' + idAddress + '">'+
                                                                    '<td>' + thisArraySorted[polozka] + '</td>'+
                                                                    '<td id="extCourse_' + idAddress + '"></td>'+
                                                                    '<td id="intCourse_' + idAddress + '"></td>'+
                                                                    '<td id="picker_' + idAddress + '"></td>'+
                                                                    '<td id="realCapa_' + idAddress + '"></td>'+
                                                                    '<td id="requestedCapa_' + idAddress + '"></td>'+
                                                                    '<td id="boxUsage_' + idAddress + '"></td>'+
                                                                    '<td id="safetyStock_' + idAddress + '"></td>'+
                                                                    '<td id="hcLevel_' + idAddress + '"></td>'+
                                                                '</tr>';
                                addresesSelect +=  '<option value="' + thisArraySorted[polozka] + '">'  + thisArraySorted[polozka] + '</option>';
                                
                            };
                                cil_3.val(multiAddressList);
                        

                            //jeste pridam PC-store adresu je-li ...
                            if(addresType == 'ika'){
                                let idPcStore = pc_store;
                                if(idPcStore !== null){ // pokud bych nemel tuto podminku, tak by selhala funkce replace
                                    idPcStore = idPcStore.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID;
                                }
                                addresesTable +=  '<tr id="rowAddres_' + idPcStore + '">'+
                                                                    '<td class="rowWithPcStore" id="pcStoreAddress">' + idPcStore + '</td>'+
                                                                    '<td class="rowWithPcStore" id="extCourse_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="intCourse_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="picker_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="realCapa_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="requestedCapa_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="boxUsage_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="safetyStock_' + idPcStore + '"></td>'+
                                                                    '<td class="rowWithPcStore" id="hcLevel_' + idPcStore + '"></td>'+
                                                                '</tr>';
                            };
                        
                        }else{
                            addresesTable +=  '<tr><td colspan="9">ŽÁDNÉ ADRESY PRO ZVOLENÝ DATUM</td></tr>';
                        };
                            addresesSelect +=  anotherAddress;
                        // vypisu ...
                        cil_1.html(addresesTable);
                        cil_2.html(addresesSelect);
                        // a ulozim do localstorage.
//                        localStorage.addressesTable=addresesTable;
                        localStorage.addresesSelect=addresesSelect;
                    }
                    
                    function getCourses(data, addresType){
                        for(let polozka in data) {                            
                                let idAddress = data[polozka][addresType];
                                if(idAddress !== null){ // pokud bych nemel tuto podminku, tak by selhala funkce replace
                                    idAddress = idAddress.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID
                                }
                                

                                let TC = $('#ADR_year').val() + $('#ADR_month').val() + $('#ADR_day').val(); //TC looked for
                                //continue only if TC is what I want
                                if( (data[polozka]['date from'] <= TC) && (data[polozka]['date to'] >= TC) && data[polozka][addresType] !== null){
                                
                                    let extCourse = data[polozka]['ext course'];
                                    let intCourse = data[polozka]['int course'];

                                    // ext. kurz pro direct
                                    $('#extCourse_' + idAddress ).text(extCourse);
                                    // int. kurz pro direct
                                    (intCourse !== null ?  $('#intCourse_' + idAddress ).text(intCourse) : $('#intCourse_' + idAddress ).text('-') );


                                        //ext. kurz pro PC-store
                                        if(addresType == 'ika'){
                                            let idPcStore = data[polozka]['kpa'];
                                            if(idPcStore !== null){ // pokud bych nemel tuto podminku, tak by selhala funkce replace
                                                idPcStore = idPcStore.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID;
                                            }
                                                $('#extCourse_' + idPcStore ).text(extCourse); 

                                        //int. kurz pro PC-store
                                                $('#intCourse_' + idPcStore ).text('-');
                                        };
                                };
                        };  
                    }

            
                    
                    
                    //ulozi html kod casti stranky - tabulky
                    function saveAddressTable(){
                        localStorage.addressTable_content = $('#tbody_adresy_zasoby').html();
                    }


                            
