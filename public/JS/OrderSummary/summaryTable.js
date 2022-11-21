$(document).ready( function () {

var kanban= $('#kanbanOS');

    kanban.change(function(){
        if((kanban.val()).length == 4){
            
            data_divert_OrderSummary(kanban.val());
            
        }else{
            alert('KBN číslo musí mít 4 znaky. \n\n err.2');
        }
    });

});



        
        


function data_divert_OrderSummary(kanban){
var API_getOrderSummaryData = $('#API_getOrderSummaryData').val();

 $.ajax({
    url: API_getOrderSummaryData + kanban + '&application=hotcall',
    dataType: "json",
    method: 'get',
    success: function (data) {


        if(data != ''){
            getOrderSummaryAll(data);
            myDataTables();
        }else{
            $('#tbody_order_summary_ALL').html('<td>ŽÁDNÁ DATA</td>');
        } 
                
         

    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Divert - Order Summary". \nZkontroluj KBN číslo. \n\n err.1');
        clearDestroy2('refresh');
    }
});
}


                    function getOrderSummaryAll(data){
                        let polozka; // polozka pro cyklus
                        let table = '';

                        // 
                        for(let polozka in data) {
                            
                        table += '<tr>'+
                                '<td>' + data[polozka]['supplier'] + '</td>' +
                                '<td>' + data[polozka]['dock'] + '</td>' +
                                '<td>' + data[polozka]['kanban'] + '</td>' +
                                '<td>' + data[polozka]['manifest'] + '</td>' +
                                '<td>' + data[polozka]['mros'] + '</td>' +
                                '<td>' + data[polozka]['ordered box'] + '</td>' +
                                '<td>' + data[polozka]['part number'] + '</td>' +
                                '<td>' + data[polozka]['part suffix'] + '</td>' +
                            '</tr>';

                        }
                        
                        //vypis sestavenou tabulku
                        $('#tbody_order_summary_ALL').html(table);
                        
                    }
                    
                    
                    function myDataTables(){

                        //DATATABLES
                            // Setup - add a text input to each footer cell
                            $('#summaryTable thead tr').clone(true).appendTo( '#summaryTable thead' );
                            $('#summaryTable thead tr:eq(1) th').each( function (i) {
                                var title = $(this).text();
                                $(this).html( '<input type="text" placeholder="Hledat: '+title+'" />' );

                                $( 'input', this ).on( 'keyup change', function () {
                                    if ( table.column(i).search() !== this.value ) {
                                        table
                                            .column(i)
                                            .search( this.value )
                                            .draw();
                                    }
                                } );
                            } );

                            var table = $('#summaryTable').DataTable( {
                                "order": [[ 3, "desc" ]],
                                orderCellsTop: true,
                    //            fixedHeader: true, /*neni fukcni soucasne se skrolovanim*/
                                scrollY: 600, /*vyska tabulky a to ze je rolovatelna dle Y*/
                                deferRender: true, /*odlozit vykresleni*/
                                scroller: true,
                                retrieve: true,  
                                /*
                                *  bez "retrieve: true" skáče chyba 
                                *  DataTables warning: table id=summaryTable - Cannot reinitialise DataTable. 
                                *  For more information about this error, please see http://datatables.net/tn/3
                                */

                    //            dom: 'Bfrtip', /*umisteni tlacitek*/ /* lepsi bude pouzit container nize */
                                buttons: ['excel','copy','csv','pdf','print']
                            } );

                            table.buttons( 0, null ).containers().appendTo( '#myButtonsPosition' );
                    }