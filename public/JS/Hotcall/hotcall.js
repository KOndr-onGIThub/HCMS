$(document).ready(function(){

    // zmena tridy (pozadi) pro inputy atd.
        $("input, option").hover(      // při aktivování prvku                   
            function() {
                $(this).addClass('hover_bck-gnd_1'); // se konkrétnímu prvku, nad kterým je kurzor, přidá třída
            }, function() {
              $(this).removeClass('hover_bck-gnd_1'); // a při deaktivaci se třída odebere
            }
        );

    // Addresses preference
        //PRI ZMENE mesice, dne nebo check boxu
            $('#ADR_month, #ADR_day, #ADRpref').change( function () {
                preferADR(); // set
                saveADRDate(); // save to local storage
            });
        //PRI NACTENI
            preferADR(); // set
            $('#ADR_year, #ADR_month, #ADR_day').change( function(){
                saveADRDate(); // save to local storage
            }); 


    // Order Summary preference
        //PRI ZMENE mesice, dne nebo check boxu
            $('#OrdSumm_month, #OrdSumm_day, #OSpref').change( function () {
                preferOS(); // set
                saveOrderSummDate(); // save to local storage
            });
        //PRI NACTENI
            preferOS(); // set
            $('#OrdSumm_year, #OrdSumm_month, #OrdSumm_day').change( function(){
                saveOrderSummDate(); // save to local storage
            });            


    //to clear form when it was submited succesfully
        if( $('#call_time').val() == $('#noFin_startTime_0').text() ){
            var refresh = 'NO'; //defaut must be NO to avoid loop

            refresh = $('#kanban').val() != '' ? 'refresh' : 'NO' ;

            clearDestroy1(); 
            clearDestroy2( refresh );
        };


    //SEKCE POZADI DLE DRUHU HC (Dil, Empty Box, Zamena)
        //PRI ZMENE
            radio_condition(); 
        //PRI NACTENI
            $('.radio').change( function () {
                radio_condition(); 
            });

    //SEKCE BARVENI RAMECKU SMEN
        //PRI ZMENE
            $('#shift').change( function () {
                shiftColors();
            });
        //PRI NACTENI
            shiftColors();

    //SEKCE KLAVESNICE
        // ENTER se bude chovat jako TAB
            $('body').on('keydown', 'input, select', function(e) {
                if (e.key === "Enter") {
                    var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });

        //// ignorovat ENTER
            //  $('body').keydown(function(event){
            //    if(event.keyCode == 13) {
            //      event.preventDefault();
            //      return false;
            //    }
            //  });

    // SEKCE ovladani atributu disabled pro select-box pro vybrani tabletu na ktery poslat HC
        //PRI ZMENE
            var whom = $('#whom_1 optgroup').children();
            whom.click( function () {
                var whomVal = $(this).val();
                selectBoxTAB(whomVal);
            });  
        //PRI NACTENI
            //not neded - because TABLET is default in HTML attr. selected="selected" 


    // SEKCE nahradit desetinou carku teckou
         var stock_box = $('#stock_box');
        // pri zmene
            stock_box.change( function () {
                commaDot(stock_box);
            });
        //PRI NACTENI
                commaDot(stock_box);
           

});


function radio_condition(){
                var checked_radio = $('input[name=kind_of_hc]:checked', '.radio').attr('id');
                switch (checked_radio) { 
                        case 'radio_HC': 
                                $('body').css('background', '#B9CBAF' );
                                break;
                        case 'radio_EB': 
                                $('body').css('background', '#6BA2E4' );
                                break;
                        case 'radio_mistake': 
                                $('body').css('background', '#FFABAB' );
                                break;		
                        default:
                                ;
                }
            };


function shiftColors() {
                if( $('#shift').val() === 'A'){
                    $('#shift').css('border', '20px solid rgba(255, 255, 0, 0.5)');
                } else if( $('#shift').val() === 'B'){
                    $('#shift').css('border', '20px solid rgba(0, 0, 255, 0.8)');
                }else if( $('#shift').val() === 'C'){
                    $('#shift').css('border', '20px solid rgba(0, 255, 0, 0.5)');
                }else {
                    $('#shift').css('border', '20px solid rgba(255, 0, 0, 0.5)');
                };
            };

// ovladani atributu disabled pro select-box pro vybrani tabletu na ktery poslat HC
function selectBoxTAB(whomVal) {
                var disabled = $('#delivery_boy');
                if( whomVal !== 'TABLET'){                
                    disabled.attr('disabled', 'disabled');
                }else{
                    disabled.attr('disabled', null);
                };
            };


function preferADR (){
                let y = $('#ADR_year');
                let m = $('#ADR_month');
                let d = $('#ADR_day');
    if ($('#ADRpref').is(':checked')) {
            y.attr('readonly', false );
            m.attr('readonly', false );
            d.attr('readonly', false );
            
            m.val().length == 1 ? m.val( '0'+ m.val()) : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
            d.val().length == 1 ? d.val( '0'+ d.val()) : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
            
            $('#spanADRpref').addClass('hover_bck-gnd_2'); // prida tridu, ktera obarvi pozadi
    }else{

            let date = new Date();
            let year = moment(date).format("Y");
            y.val(year);
            let month = moment(date).format("MM");
            m.val(month);
            let day = moment(date).format("DD");
            d.val(day);

            y.attr('readonly', true );
            m.attr('readonly', true );
            d.attr('readonly', true );
            
            $('#spanADRpref').removeClass('hover_bck-gnd_2'); // odebere tridu, ktera obarvila pozadi
    }
}
            

function preferOS (){
                let y = $('#OrdSumm_year');
                let m = $('#OrdSumm_month');
                let d = $('#OrdSumm_day');
    if ($('#OSpref').is(':checked')) {
            y.attr('readonly', false );
            m.attr('readonly', false );
            d.attr('readonly', false );
            
            m.val().length == 1 ? m.val( '0'+ m.val()) : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
            d.val().length == 1 ? d.val( '0'+ d.val()) : ''; // aby 1-digit cisla prevedlo na 2-digit (s nulou na zacatku)
            
            $('#spanOSpref').addClass('hover_bck-gnd_2'); // prida tridu, ktera obarvi pozadi
    }else{

            let date = new Date();
            let year = moment(date).format("Y");
            y.val(year);
            let month = moment(date).format("MM");
            m.val(month);
            let day = moment(date).format("DD");
            d.val(day);

            y.attr('readonly', true );
            m.attr('readonly', true );
            d.attr('readonly', true );
            
            $('#spanOSpref').removeClass('hover_bck-gnd_2'); // odebere tridu, ktera obarvila pozadi
    }
}


function commaDot(stock_box){
                var stock_boxVal = stock_box.val();
                stock_boxVal = stock_boxVal.replace(',','.');
                stock_box.val(stock_boxVal);
}


function saveADRDate(){
    localStorage.ADR_year=$('#ADR_year').val();
    localStorage.ADR_month=$('#ADR_month').val();
    localStorage.ADR_day=$('#ADR_day').val();
}
                
                
function saveOrderSummDate(){
    localStorage.OrdSumm_year=$('#OrdSumm_year').val();
    localStorage.OrdSumm_month=$('#OrdSumm_month').val();
    localStorage.OrdSumm_day=$('#OrdSumm_day').val();
}