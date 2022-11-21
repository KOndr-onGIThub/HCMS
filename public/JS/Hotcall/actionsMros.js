$(document).ready(function(){


                
var kanban = $('#kanban');
var region = $('#kanban, #actual_mros, #OrdSumm_year, #OrdSumm_month, #OrdSumm_day, #OSpref');
var region2 = $('#kanban, #ADR_year, #ADR_month, #ADR_day, #ADRpref');



    region.change(function(){

            data_divert_OrderSummary(kanban.val());
            //DockData(kanban.val());
 
    });


    region2.change(function(){

            DockData(kanban.val());
 
    });
    
    


});




                
