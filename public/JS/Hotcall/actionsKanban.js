$(function(){


                
var kanban=$('#kanban');
    // to change letters to capital
    kanban.keyup( function () {
    kanban.val( kanban.val().toUpperCase() );
    });

        kanban.change(function(){

            if((kanban.val()).length == 4){

    //            //datum ve formatu pro zobrazeni uzivateli
    //                var date = new Date();
    //                    date = moment(date).locale('cs').format('LL');
    //                    $('#call_time_date').val(date);
    //                        // ulozit do local storage (knihovna savy tady nefunguje, bo uklada jen kdyz opustim bunku, ale ja do ni tady vubec nejdu)
    //                        localStorage.call_date=date;
    //            //cas ve formatu pro zobrazni uzivateli
    //                var time = new Date();
    //                    time = moment(time).format("HH:mm :ss");
    //                    $('#call_time_time').val(time);
    //                        // ulozit do local storage (knihovna savy tady nefunguje, bo uklada jen kdyz opustim bunku, ale ja do ni tady vubec nejdu)
    //                        localStorage.call_time=time;
                // datum a cas v DB formatu pro ulozeni do DB
                    var dateTime = new Date();
                        dateTime = moment(dateTime).format("YYYY-MM-DD HH:mm:ss");    
                        $('#call_time').val(dateTime);
                            // ulozit do local storage (knihovna savy tady nefunguje, bo uklada jen kdyz opustim bunku, ale ja do ni tady vubec nejdu)
                            localStorage.call_datetime=dateTime;                

                var kbnChanged = 'YES'; //YES means kanban was changed. I use param NO in different situation


                data_NG_parts(kanban.val(), kbnChanged); 

                //zjisti zda HC na tento dil neni mazi neukoncenymi HC
                var urlReoccurHotcall = $('#reoccurHotcall').val();
                ajax_reoccurHC(urlReoccurHotcall, kanban.val());

    //            data_divert_OrderSummary(kanban.val()); // PRESUNUTO do actionsMros


    //            data_divert_Divert();  // tento ajax volam v ajaxu data_NG_parts, protoze musi jiz byt dobehnuty, aby z nej mel data
    //            DockData(); // tento ajax volam v ajaxu data_NG_parts, protoze musi jiz byt dobehnuty, aby z nej mel data        
    //            data_divert_ILSS(kanban.val());  // tyto data budou volana v DockData() resp. ajax_dockCodes.js

                data_ovf_kanban(kanban.val()); 

//                data_redPost(); //presunuto do actionTime.js



            }else{
                clearDestroy2('refresh');
            }


        });


});





