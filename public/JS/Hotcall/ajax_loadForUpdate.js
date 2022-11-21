$(function(){

     $('.loadForUpdate').click( function () {
        let idOfButton = $(this).attr('id');

        // tim dostanu id bunky ve ktere mam id hotcallu na danem radku 
        let idOfCell = idOfButton.replace('noFin_btn_loadForUpdate_', '#noFin_id_'); 
        let idOfHC = $(idOfCell).text();
        
        //PREDAT ID skrytemu inputu PRO POZDEJSI AKTUALIZACI
        $('#idForUpdateINFO').attr('value', idOfHC);
        
        var url= $('#getDataForUpdate').val() + "/" + idOfHC;
        
        getDataForUpdate(url);
     });

    
     $('#btn_update').click( function () {
        let idOfHC = $('#idForUpdateINFO').val();
        let boxes_for_delivery = $('#boxes_for_delivery').val() == "" ? '0' : $('#boxes_for_delivery').val();
        let note_to_write = $('#note_to_write').val() == "" ? '0' : $('#note_to_write').val();
        let plan_mros = $('#plan_mros').val() == "" ? '0' : $('#plan_mros').val();
        let actual_mros = $('#actual_mros').val() == "" ? '0' : $('#actual_mros').val();
        let stock_min = $('#stock_min').val() == "" ? '0' : $('#stock_min').val();
        let stock_pcs = $('#stock_pcs').val() == "" ? '0' : $('#stock_pcs').val();
        let stock_boxes = $('#stock_box').val() == "" ? '0' : $('#stock_box').val();
        let address = $('#address').val();
        let shift = $('#shift').val();
        let whom_1 = $('#whom_1').val();
        let delivery_boy = $('#delivery_boy').val().trim();
        let kind_of_hc = $('input[name=kind_of_hc]:checked', '.radio').val();
        let errorsForUpdate = ''; //container in case of error message needed

        errorsForUpdate += boxes_for_delivery >=0 ? '' : 'ZAVÉZT BOXŮ je menší než 0 \n' ;
        errorsForUpdate += boxes_for_delivery <=99 ? '' : 'ZAVÉZT BOXŮ je větší než 99 \n' ;
        errorsForUpdate += note_to_write.length <=100 ? '' : 'DOPLŇUJÍCÍ POZNÁMKA je delší než 100 znaků \nJe to ' + note_to_write.length + ' znaků.';
        
        if( errorsForUpdate == ''){

        HC_isUpdated(idOfHC, boxes_for_delivery,note_to_write,plan_mros,actual_mros,stock_min,stock_pcs,stock_boxes,address,shift,whom_1,delivery_boy,kind_of_hc);
        }else{
            alert(errorsForUpdate);
        }
        
//         $.getJSON($('#getDataForUpdateINFO').val()+'/'+idOfHC+'/'+boxes_for_delivery, function(data) {
////    doSomethingWith(data);
//});
     });

});

    // nactu si info dle id a dále pouziju k vyplnění formulaře
    function getDataForUpdate(url){
     $.ajax({
        url: url,
        dataType: "json",
        method: 'get',
        success: function (data) {
             //console.log(data);

            if((data != '')) {
//                console.log(data);
                // vyčistit to co nepotřebuji, resp. by se mohlo plást nebo vést k omylům
                clearDestroy1(); 
                clearDestroy2();
                $('.destroy2').val('');
                $('#tbody_order_summary, #tbody_ovf, #OVFlegend').attr('hidden', true);
                //skryt tlacitko odeslat, aby nedošlo k zalozeni nového duplicitniho zaznamu v DB
                $('#send').attr('hidden', true);
                //odekrýt tlacitko pro update
                $('#btn_update').attr('hidden', false);
                
                //naloudovat původní data
                $('#shift').val(data['shift']);
                shiftColors(); //obarvit ramecek shift
                $('#call_time').val(data['call_time']);
                $('#kanban').val(data['kanban']);
                $('#address').empty().append($('<option></option>').attr("value", data['address']).text(data['address']));
                $('#address').append($('<option></option>').attr("value", 'jinaAdresa').text('jiná adresa'));             
                $('#stock_box').val(data['stock_boxes']);
                $('#stock_pcs').val(data['stock_pcs']);
                $('#stock_min').val(data['stock_min']);
                $('#actual_mros').val(data['actual_mros']);
                $('#plan_mros').val(data['plan_mros']);
                $('#note_to_write').val(data['note_to_write']);
                $('#boxes_for_delivery').val(data['boxes_for_delivery']);
                
                // oznacit komu byl HC původně předán
                if(data['delivery_boy'].slice(0,3) == 'TAB'){
                    $('#whom_1').val('TABLET');
                    $('#delivery_boy').attr('disabled', false);
                    
                    $('#delivery_boy').children().attr('selected',false); // odznacit to co je oznaceno
                    $('#delivery_boy option:nth-child('+data['delivery_boy'].slice(4,5)+')').attr('selected',true); // oznacit to k cemu se vztahuje danny HC
                }else{
                    $('#whom_1').val(data['delivery_boy']);
                    $('#delivery_boy').attr('disabled', true);
                }
                
                        var radioPointers = $('.pointer');
                        radioPointers.attr('checked', false);
                        
                        let pointed_radio = data['kind_of_hc'];
                        
                                            
                                            switch (pointed_radio) { 
                                                    case 'DÍL': 
                                                            $('#radio_HC').attr('checked', true);
                                                            $('body').css('background', '#B9CBAF' );
                                                            localStorage.radio_pointers=$('#radio_pointers').html();
                                                            break;
                                                    case 'Empty Box': 
                                                            $('#radio_EB').attr('checked', true);
                                                            $('body').css('background', '#6BA2E4' );
                                                            localStorage.radio_pointers=$('#radio_pointers').html();
                                                            break;
                                                    case 'Záměna': 
                                                            $('#radio_mistake').attr('checked', true);
                                                            $('body').css('background', '#FFABAB' );
                                                            localStorage.radio_pointers=$('#radio_pointers').html();
                                                            break;		
                                                    default:
                                                            ;
                                            }
                                            $('#radio_pointers').html(localStorage.radio_pointers);
                                        
                        
                        
                        
//                    $('.pointer').val(data['kind_of_hc']);
                
                //nemuzu dovolit prepsat nektera data
                $('#kanban').attr('readonly', 'readonly');
                
                
            }
        },
        error: function(){
            alert('Nepodarilo se nacist data z ajax_loadForUpdate.js. \n\n err.1');
        }
    });
    }


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function HC_isUpdated(idOfHC, boxes_for_delivery,note_to_write,plan_mros,actual_mros,stock_min,stock_pcs,stock_boxes,address,shift,whom_1,delivery_boy,kind_of_hc) {
    let _token   = $('meta[name="csrf-token"]').attr('content');  
    
    $.ajax({
        url: $('#getDataForUpdateINFO').val()+'/ajax-request',
        type:"POST",
        data:{
          idOfHC:idOfHC,
          boxes_for_delivery:boxes_for_delivery,
          note_to_write:note_to_write,
          plan_mros:plan_mros,
          actual_mros:actual_mros,
          stock_min:stock_min,
          stock_pcs:stock_pcs,
          stock_boxes:stock_boxes,
          address:address,
          shift:shift,
          whom_1:whom_1,
          delivery_boy:delivery_boy,
          kind_of_hc:kind_of_hc,
          _token: _token
        },
        success:function(response){
//          console.log(response);
          if(response) {
                clearDestroy1(); 
                clearDestroy2( 'refresh' );
//            $('.success').text(response.success);
//            $("#ajaxform")[0].reset();
          }
        },
        error: function(error) {
//         console.log(error);
            alert('Nepodarilo se aktualizovat záznam.\nZkontrolujte správnost zadaných informací.  \n\n err.1');
        }
       });
}