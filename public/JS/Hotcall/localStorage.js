$(function(){



    //nacist hodnoty z local storage
    //tady knihovnu savy nepouzivam, nebot (knihovna savy uklada jen kdyz opustim bunku, ale ja do ni tady vubec nejdu)
    $("#call_time_time").val(localStorage.call_time);
    $("#call_time_date").val(localStorage.call_date);
    $("#call_time").val(localStorage.call_datetime);
    
    $('#partVariant').html(localStorage.selectBoxOfVariant);
    $("#partName").val(localStorage.partName);
    $("#partNumber").val(localStorage.partNumber);
    $("#supplierName").val(localStorage.supplierName);
    $("#supplierCode").val(localStorage.supplierCode);
    $("#dockCode").val(localStorage.dockCode);
    $("#paletizationCode").val(localStorage.paletizationCode);
    $("#boxType").val(localStorage.boxType);
    $("#boxLot").val(localStorage.boxLot);
    $("#specialistCode").val(localStorage.specialistCode);
    $("#build_out_code").val(localStorage.build_out_code);
    $("#build_out_yes_no").val(localStorage.build_out_yes_no);
    $("#modelToyota").val(localStorage.modelToyota);
    $("#modelToyota").css('background', localStorage.modelToyotaColor);
    $("#modelToyota").attr('title', localStorage.modelToyotaTitle);
    $("#listOfmodels").val(localStorage.listOfmodels);

    $('#address').html(localStorage.addresesSelect);
    $('#tbody_adresy_zasoby').html(localStorage.addressTable_content);
    $('#tbody_order_summary').html(localStorage.orderSummTable_content);
    $('#tbody_ovf').html(localStorage.ovfTable_content);
    $('#tbody_redpost').html(localStorage.redPostTable_content);
    
    $('#divert_part').html(localStorage.divert_part);
    $('#divert_supplier').html(localStorage.divert_supplier);
    $('#divert_id').html(localStorage.divert_id);
    
    $('#OrdSumm_year').val(localStorage.OrdSumm_year);
    $('#OrdSumm_month').val(localStorage.OrdSumm_month);
    $('#OrdSumm_day').val(localStorage.OrdSumm_day);
    
    $('#ADR_year').val(localStorage.ADR_year);
    $('#ADR_month').val(localStorage.ADR_month);
    $('#ADR_day').val(localStorage.ADR_day);
    
let item = localStorage.SecondaryData_content;
     item != '' ? $('#hidenSecondaryData').html(item) : ''; // tady je vyjimka, bo obsahem je take cast html stranky (skryte inputy), ktere tam musim nechat, jinak by nefungovali dalsi veci


    // nacist (resp. ulozit, po opusteni bunky) do localstorage vse se tridou .saved
    $('.saved').savy('load');
    


    // smazat hodnoty v local storage
    $('#destroy').click(function(){
            clearDestroy1();
            clearDestroy2('refresh');
    });

            
    

});
    
    // oblasti pro mazani mam dve, protoze v nekterych situaci chci smazat jen jednu znich
    function clearDestroy1( refresh ){
        $('.destroy').savy('destroy'); // pro mazani mam zvlastni tridu, abych nesmazal smenu
        //smazat i datum a cas
//        localStorage.call_date=''; 
//        localStorage.call_time='';
        

        if(refresh == 'refresh'){
            location.reload(); // refresh,   
        };
    }
    
    function clearDestroy2( refresh ){
        localStorage.selectBoxOfVariant='';
        localStorage.partName='';
        localStorage.partNumber='';
        localStorage.supplierName='';
        localStorage.supplierCode='';
        localStorage.dockCode='';
        localStorage.paletizationCode='';
        localStorage.boxType='';
        localStorage.boxLot='';
        localStorage.specialistCode='';
        localStorage.build_out_code='';
        localStorage.build_out_yes_no='';
        localStorage.modelToyota='';
        localStorage.modelToyotaColor='';
        localStorage.modelToyotaTitle='';
        localStorage.listOfmodels='';
        
        localStorage.addresesSelect='';
        localStorage.addressTable_content='';
        localStorage.SecondaryData_content='';
        localStorage.orderSummTable_content='';
        localStorage.ovfTable_content='';
        localStorage.redPostTable_content='';
        
        localStorage.divert_part='';
        localStorage.divert_supplier='';
        localStorage.divert_id='';
        
        if(refresh == 'refresh'){
            location.reload(); // refresh, 
        };         
    }

