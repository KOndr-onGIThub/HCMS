$(document).ready( function () {
   
            
    data_divert_Divert();
            

});


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function data_divert_Divert(){
let ajaxUrl = $('#getDivertData').val(); // url je v tomto skritem inputu

 $.ajax({
    url: ajaxUrl,
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);

        getDivertAll(data);
        getDataTables(data)
        
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Divert". \n\n err.1');
        clearDestroy2('refresh');
    }
});
}



                    function getDivertAll(data){

                        let content;
                        
                        
                    for(let polozka in data) {
                            //
                            let kanban = data[polozka]['kanban'];
                            
                            kanban === null ? kanban = 'ALL KANBANS': '';
                                

                            content +=  '<tr><td>' + kanban + '</td>' +
                                        '<td>' + data[polozka]['supplier'] + '</td>' +
                                        '<td>' + data[polozka]['dock'] + '</td>' +
                                        '<td>' + data[polozka]['last update'] + '</td></tr>';
                            
                            
                        };
                        
                    $('#tbody_divert_ALL').html( content );
                    }

                    function getDataTables(data){
                    //DATATABLES
                        // Setup - add a text input to each footer cell
                        $('#divertTable thead tr').clone(true).appendTo( '#divertTable thead' );
                        $('#divertTable thead tr:eq(1) th').each( function (i) {
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

                        var table = $('#divertTable').DataTable( {
                            "order": [[ 0, "asc" ]],
                            orderCellsTop: true,
                            fixedHeader: true, /*neni fukcni soucasne se skrolovanim*/
                            scrollY: 600, /*vyska tabulky a to ze je rolovatelna dle osy Y*/
                            deferRender: true, /*odlozit vykresleni*/
                            
                            "pageLength": 100, //defaultni pocet ukazanych zaznamu

                            buttons: ['excel','copy','csv','pdf','print'],
                        } );

                        table.buttons( 0, null ).containers().appendTo( '#myDivertButtonsPosition' );
    
                    }
    

