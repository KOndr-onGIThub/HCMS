$(document).ready(function(){
               
var address = $('#address');

    address.change(function(){
        
            prepareSecondaryData(address.val());
            
            highlightSelectedAddress(address.val());
            
            saveAddressTable(); // resave becouse need to save including highlight // function is placed in ajax_divert.js
            
            saveSecondaryData(); // save to local storage to be available for send to database
 
    });
});

function prepareSecondaryData(address){
    // do skryteho inputu '#course_stocker' nactu hodnotu prislusneho kurzu //stocker course = External course = course on external kanban
    // prislusny kurz obsahuje bunka tabulky 'ADRESY&ZASOBY' prislusneho radku
    // prislusny radek je dan idckem '#extCourse_' a adresou bez mezer a s pomlckama misto lomitek
    // u tech hodnot co v databazi nesmeji byt prazdne jeste nahrazuji pripane nulou
    
    address = address.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID
    
        let idExternalCourse = '#extCourse_' + address;
        let valueExternalCourse = $(idExternalCourse).text();
        $('#course_stocker').val(valueExternalCourse);
    //stejna logika pro dalsi pole
        let idPickerCourse = '#picker_' + address;
        let valuePickerCourse = $(idPickerCourse).text();
        $('#course_picker').val(valuePickerCourse);
    //stejna logika pro dalsi pole //delivery course = Internal course = course on internal kanban
        let idDeliverCourse = '#intCourse_' + address;
        let valueDeliverCourse = $(idDeliverCourse).text();
        $('#course_deliver').val(valueDeliverCourse);
    //stejna logika pro dalsi pole (tady ale bez adresy)
        let idStoreAddress = '#pcStoreAddress';
        let valueStoreAddresse = $(idStoreAddress).text();
        $('#address_store').val(valueStoreAddresse);
    //stejna logika pro dalsi pole
        let idCapaRequested = '#requestedCapa_' + address;
        let valueCapaRequested = $(idCapaRequested).text();
        $('#line_side_capacity_requested').val(valueCapaRequested != '' ? valueCapaRequested : 0);
    //stejna logika pro dalsi pole
        let idCapaReal = '#realCapa_' + address;
        let valueCapaReal = $(idCapaReal).text();
        $('#line_side_capacity_real').val(valueCapaReal != '' ? valueCapaReal : 0);
    //stejna logika pro dalsi pole
        let idSafetyLineSide = '#safetyStock_' + address;
        let valueSafetyLineSide = $(idSafetyLineSide).text();
        $('#safety_boxes_line_side').val(valueSafetyLineSide != '' ? valueSafetyLineSide : 0);
    //stejna logika pro dalsi pole (tady ale s PC-store adresou)
        let idSafetyPcStore = '#safetyStock_' + $('#pcStoreAddress').text().replace(/ /g, '').replace('/', '-');
        let valueSafetyPcStore = $(idSafetyPcStore).text();
        $('#safety_boxes_pc_store').val(valueSafetyPcStore != '' ? valueSafetyPcStore : 0);
    //stejna logika pro dalsi pole
        let idHcLevel = '#hcLevel_' + address;
        let valueHcLevel = $(idHcLevel).text();
        $('#hc_level').val(valueHcLevel != '' ? valueHcLevel : 0);
    //stejna logika pro dalsi pole
        let idBoxUsage = '#boxUsage_' + address;
        let valueBoxUsage = $(idBoxUsage).text();
        $('#boxUsage').val(valueBoxUsage);


  
}

function highlightSelectedAddress(address){
    
//odebrat pripadně předešle vloženou třídu
$('#adresy_zasoby .hover_bck-gnd_1').removeClass('hover_bck-gnd_1');


    address = address.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID

//pridat tridu radku s vybranou adresou
let what = '#rowAddres_' + address ;
    $(what).addClass('hover_bck-gnd_1');

    
}


//ulozi html kod casti stranky - divu
function saveSecondaryData(){
    localStorage.SecondaryData_content = $('#hidenSecondaryData').html();
}