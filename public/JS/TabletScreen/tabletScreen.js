$(function(){
    
    
    var btnShowKanbanPickingDialog = $('#btnShowKanbanPickingDialog');
    let original = btnShowKanbanPickingDialog.text();
    let back = 'ZPĚT';
    
    var oKanbanDetailDialog = $("#divDlgDetail").dialog({
            width: 780,
            resizable: false,
            closeOnEscape: false,
            draggable: false,
            autoOpen: false,
            modal: true
        });

        $("#divDialogCloseButton").click(function () {
            oKanbanDetailDialog.dialog("close");
        });

        $("body").on("click", ".tdKanban", function () {
         let idTableCell = $(this).attr('id');
            // tim dostanu id bunky ve ktere mam id hotcallu na danem radku 
            let idOfHC = idTableCell.replace('tdKanban_', ''); 
            
            $('#tdSupplierName').text($('#tdSupplierName_' + idOfHC).text());
            $('#tdMultiaddress').text($('#tdMultiaddress_' + idOfHC).text());
            $('#tdSupplierCode').text($('#tdSupplierCode_' + idOfHC).text());
            $('#tdBoxUsage').text($('#tdBoxUsage_' + idOfHC).text());
            $('#tdBoxSize').text($('#tdBoxSize_' + idOfHC).text());
            $('#tdBoxLot').text($('#tdBoxLot_' + idOfHC).text());
            $('#tdDeliveryCourse').text($('#tdDeliveryCourse_' + idOfHC).text());
            $('#tdPcStoreAddress').text($('#tdPcStoreAddress_' + idOfHC).text());
            $('#tdOverflowZone').text($('#tdOverflowZone_' + idOfHC).text());
            $('#tdBoxCountInOverflow').text($('#tdBoxCountInOverflow_' + idOfHC).text());
            $('#spanKanban').text($('#tdKanban_' + idOfHC).text());
            
            clearInterval(oReloadInterval);
            setReloadInterval();
            oKanbanDetailDialog.dialog("open");
        });

    let oKeyboardDialog = $("#divKeyboardDlg").dialog({
        width: 780,
        resizable: false,
        closeOnEscape: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        position: {my: "center top", at: "center top", of: $("#tblHotcall")}
    });
    
    $("#spanKeyboardBack").click(function () {
        $('#divTabletContentContainer, #header').attr('hidden', false);
        setReloadInterval();
        afterClickKeyboardBack(oKeyboardDialog);
    });
    
    $(".tdKey").click(function () {
        var button = $(this);
        afterClickTdKey(button);
    });

    $("#spanKeyboardOk").click(function () {
        afterClickKeyboardOk(oKeyboardDialog);
    });
    
    var oReloadInterval;
    var reloadInterval = 15000;  // jak casto refresovat 
    var setReloadInterval = function () {
        clearInterval(oReloadInterval);
        oReloadInterval = setInterval(function () {
            $(".status_HC, .finish_HC").attr("hidden", true); 
            location.reload();
        }, reloadInterval);
    };

    setReloadInterval();

//----------------------------------------------------------------------------------------
    // po kliknuti na tlacitko se skreje jeden kontejner a zobrazi druhy
    btnShowKanbanPickingDialog.click(function(){
                            //nacist tabulku z local storage
                            $("#bodyKanbanPicking").html(localStorage.bodyKanbanPicking);
                            
            // oznacit-odznacit bunky
            $(".tdKanbanPickingStatus").click(function () {   
                var cell = $(this);
                afterClickCell(cell);
                localStorage.bodyKanbanPicking = $("#bodyKanbanPicking").html();
            });

            // vymazat obsah bunek
            $("#btnClearKanbanPicking").click(function () {
                $(".tdKanbanPickingStatus").empty();
                localStorage.bodyKanbanPicking = $("#bodyKanbanPicking").html();
            });
              
        clearInterval(oReloadInterval);
        
        $('#divTabletContentContainer').toggle(900, 'easeOutQuint',function(){
                $('#divDlgKanbanPicking').toggle(900, 'easeOutQuint');
                
                if(btnShowKanbanPickingDialog.text() == original){
                        btnShowKanbanPickingDialog.text( back );
                    }else{
                        btnShowKanbanPickingDialog.text( original );
                        setReloadInterval();
                    }
            });
    });





        // podle statusu HC se v pohledu urci text tlacitka a podle textu tlacitka se zde urci styl        
        statusColor();
    

    //  .................
     $('.status_HC').click( function () {
              
         let idOfButton = $(this).attr('id');
            // tim dostanu id bunky ve ktere mam id hotcallu na danem radku 
            let idOfCell = idOfButton.replace('noFin_tabletBtn_', '#noFin_id_'); 
            let idOfHC = $(idOfCell).text();

            // zjistit aktual status (
            let statusActual = $( idOfButton.replace('noFin_tabletBtn_', '#noFin_status_') ).text();
            // zmenit status
            let statusNew = statusActual - 0 + 1; // ta nula je tam, aby cislo
            let delivered = 0;
            let remaining = 0;

            //kdy jsem klikl
            let dateTime = new Date();
                dateTime = moment(dateTime).format("YYYY-MM-DD HH:mm:ss"); 
                              
                if(statusActual == 1){

                    //zavolam ajax, ktery aktualizuje status
                    HC_statusChange(idOfHC, statusNew, dateTime, delivered, remaining);
                    // refresh
                    location.reload(); 
                }else if (statusActual == 2){
                    
                    //<!-- to remember values befor dialog will be opened -->
                    $('#solvedId').val(idOfHC);
                    $('#solvedstatus').val(statusNew);


                    clearInterval(oReloadInterval);
                    $('#divTabletContentContainer, #header').attr('hidden','hidden');
                    oKeyboardDialog.dialog("open");
                    
                    
                    
                }

     });
        
        
        //FOR ALARM SOUND
        let lastHC_ID = $('#lastHC_ID').text();
        
        if( (lastHC_ID != localStorage.lastHC_ID) && (lastHC_ID != 0) ){
           
            // show exclamation mark
            $('#spanNewHotcallAlert').attr('hidden', false);
            
            //hack pro inicializaci zvuku 
            document.getElementById('alarm').play();

            //rewrite local storage to alarm will not play again
            localStorage.lastHC_ID = lastHC_ID;
        };
        //document.getElementById('alarm').pause();



$('#selectedTabletName').change( function () {
    var $tabletName = $('#tabletURL').val() + '/' + $('#selectedTabletName').val()  ;
    window.location.href = $tabletName;
});


});

        


//AJAX>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function HC_statusChange($idOfHC, $statusNew, $dateTime, $delivered, $remaining) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let ajaxUrl = $('#statusChange').val() + '/' + $idOfHC + '/' + $statusNew + '/' + $dateTime + '/' +  $delivered  + '/' + $remaining; // url je v tomto inputu
    
    $.ajax({
        url: ajaxUrl,
        dataType: "json",
        method: 'get',
        success: function () {

//  doesn't work          // refresh
//            location.reload();
        },
        error: function(){
           // alert('Nepodarilo se ulozit data". \n!!! \n\n err. ajax HC_statusChange');
        }
    });
}
//AJAX>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function tabletSelection($tabletName) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let ajaxUrl = $tabletName ;
    
    $.ajax({
        url: ajaxUrl,
        dataType: "json",
        method: 'get',
        success: function () {

//  doesn't work          // refresh
//            location.reload();
        },
        error: function(){
           // alert('Nepodarilo se ulozit data". \n!!! \n\n err. ajax HC_statusChange');
        }
    });
}

//FUNCTIONS>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

// podle statusu HC se v pohledu urci text tlacitka a podle textu tlacitka se zde urci styl
function statusColor() {
        $( ".status_HC" ).each(function( i ) {
            let btnText = $(this).children().text();
            
            if ( btnText == "START" ) {
                  $(this).css( "background-color", "yellow" );
  //            this.style.color = "green";
            } else if ( btnText == "KONEC" ) {
                  $(this).css( "background-color", "orange" );
            }

        });
};

function afterClickKeyboardBack (oKeyboardDialog) {
    oKeyboardDialog.dialog("close");
};

function afterClickTdKey (button) {
    var value = button.html();

    var tblType = button.closest("table").data("tbltype");
    if (tblType === "delivered") {
        var display = $("#tdDisplayDelivered");
    } else {
        var display = $("#tdDisplayRemaining");
    }

    if (value !== "SMAŽ") {
        var currentValue = display.text();
        if (currentValue == "něco zadejte") {
            display.text("");
            display.text(value);
        } else {
            display.text(currentValue + value);
        }
    }

    if (value === "SMAŽ") {
        display.text("");
    }
};

function afterClickKeyboardOk (oKeyboardDialog) {
    var delivered = $("#tdDisplayDelivered").text();
    var remaining = $("#tdDisplayRemaining").text();
    var idOfHC = $("#solvedId").val();
    var statusNew = $("#solvedstatus").val();
    var dateTime = whenClicked();

    if (delivered > 99) {
        $("#tdDisplayDelivered").text(delivered + " je moc");
    } else if (delivered === "") {
        $("#tdDisplayDelivered").text("něco zadejte");
    } else if (remaining > 99.9) {
        $("#tdDisplayRemaining").text(remaining + " je moc");
    } else if (remaining === "") {
        $("#tdDisplayRemaining").text("něco zadejte");
    } else {
            //zavolam ajax, ktery aktualizuje status
            HC_statusChange(idOfHC, statusNew, dateTime, delivered, remaining); 

//            location.reload();
            $("#rowNoFin_id_" + idOfHC).attr("hidden", true); //timto nahrazen reload
            
            // odeslani do databaze probehne po uzavreni dialogu (za mistem kde jsem ho otevrel)
            oKeyboardDialog.dialog("close");
            location.reload(); //2022/08/24 najednou v DEVu po ukonceni HC zustala jen bila stranka = neobnovila se, tak pridavam tento reload. jako asi je to logicke bo v TabletScreenController je sice "return redirect('/TabletScreen');", ale toto bezi asynchrone pres ajax
    }
};


function afterClickCell (cell) {
    var content = cell.html();

    if (content === ''){
        cell.html('X');
    }else{
        cell.html('');
    }
};


function whenClicked (){
            //kdy jsem klikl
            let dateTime = new Date();
                dateTime = moment(dateTime).format("YYYY-MM-DD HH:mm:ss");
                return dateTime;
}