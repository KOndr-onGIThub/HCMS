$(document).ready(function(){

let maxRepeat = 499; // maximum radku +1 v tabulce noFinished
let intervalSecund = 30;

timeToStop(maxRepeat);
setInterval(function(){ timeToStop(maxRepeat); }, intervalSecund * 1000); // obnovit jednou za /intervalSecund/ sekund

$('#field_noFinished legend').attr('title', 'Tabulka HC, které ještě nebyly označeny jako ukončené. Limit zobrazovaných řádků je ' + maxRepeat);

$('#minutesToStop').attr('title', 'Kolik minut zbývá do zastavení linky = cas zapsání kbn čísla + zapsaný počet minut výroby - aktuální čas. K přepočtu dochází každých ' + intervalSecund + ' sekund');

// pro to aby JS pomoci ajaxu zjistil jestli uz ne/byl HC ukoncen (HotcallController.php & actionsTime.js & ajax_data.js)
let url = $('#HotcallData').val();
func_ajax_Data(url);
setInterval(function(){ func_ajax_Data(url); }, intervalSecund * 1000); // obnovit jednou za /intervalSecund/ sekund


setInterval(function(){ data_redPost(); }, intervalSecund * 1000); // obnovit jednou za /intervalSecund/ sekund

//let url_storeDaico = $('#url_storeDaico').val();
//CsvDaicoData_store(url_storeDaico); 
//setInterval(function(){ CsvDaicoData_store(url_storeDaico); }, intervalSecund * 100); // obnovit jednou za 

});


function timeToStop(maxRepeat){
    
    
    for ( let i = 0; i <= maxRepeat ; i++) {
        
        let noFin_startTime = $('#noFin_startTime_' + i);
        
        if (noFin_startTime){
            let noFin_startTime_text = $('#noFin_startTime_' + i).text();
            let noFin_stock_min_text = $('#noFin_stock_min_' + i).text();
            let stopTime = moment(noFin_startTime_text).add(noFin_stock_min_text, 'm');
            let actualTime = moment();

            let dStop = dateDiff(stopTime, actualTime);
            
            let cell = $('#noFin_timeToStop_' + i);
            cell.text( dStop );
            
            // pokud zbyva mene nez atd.\
            if( dStop <= 0 ){
                cell.addClass('stopNow');
            }else if( dStop <= 5 ){
                cell.removeClass('stopNow');
                cell.addClass('stopEarly');
            }else if( dStop <= 15 ){
                cell.removeClass('stopEarly');
                cell.addClass('stopDanger');
            }
 
            
        }else{
            i = maxRepeat;
        }
        
    }
}

function dateDiff(first, second) {
    // Take the difference between the dates and divide by milliseconds ...
    // Round to nearest whole number to deal with DST.
    return Math.round((first - second)/(1000*60));
}

