//It should be renamed to "hotcallClose"
$(document).ready(function(){
    
    
     $('.finish_HC').click( function () {
         let idOfButton = $(this).attr('id');
            $('#dialogCloseHotcall').dialog({
                buttons: {
                    ANO: function(){
                            // tim dostanu id bunky ve ktere mam id hotcallu na danem radku 
                            let idOfCell = idOfButton.replace('noFin_btn_finish_', '#noFin_id_'); 
                            let idOfHC = $(idOfCell).text();

                            // kdy jsem klikl - a prevedeni do formatu, ktery potrebuju
                            let dateTimeFinished = new Date();
                                dateTimeFinished = moment(dateTimeFinished).format("YYYY-MM-DD HH:mm:ss"); 

                            HC_isFinished(idOfHC, dateTimeFinished);

                    //        $('#rowNoFin_id_' + idOfHC).toggle(); // skryt radek, asi to neni idealni, co kdyby se zaznam do DB neulozil. Radeji to 'jen' refresnu
                        $(this).dialog('close');
                            location.reload(); // refresh,
                    },
                    NE: function(){
                        $(this).dialog('close');
                    }
                }
            });
     });
    
});

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function HC_isFinished($idOfHC, $dateTimeFinished) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let ajaxUrl = $('#HotcallFinished').val() + '/' + $idOfHC + '/' + $dateTimeFinished; // url je v tomto inputu
    
    $.ajax({
        url: ajaxUrl,
        dataType: "json",
        method: 'get',
//        success: function () {
////                 console.log();
//            },
//
//            error: function(){
//                alert($('#HotcallFinished').val() + '/' + $idOfHC + '/' + $dateTimeFinished + 'Nepodarilo se ... \n\n err.1');
//                
//            }
    });
}
