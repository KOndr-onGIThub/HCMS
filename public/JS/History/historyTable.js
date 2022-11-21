$(document).ready( function () {
    
    
    //DATATABLES
    let ajaxHistoryURL = $('#getHistoryURL').val();

                    // Setup - add a text input to each footer cell
                    $('#historyTable thead tr').clone(true).appendTo( '#historyTable thead' );
                    $('#historyTable thead tr:eq(1) th').each( function (i) {
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

        var table = $('#historyTable').DataTable( {
            "processing": true,
            "serverSide": true,
//            "ajax":ajaxHistoryURL,
            "ajax": {
                "url" : ajaxHistoryURL,
                "dataType": "json",
                "type" : "POST",
                "data": { _token: $('meta[name="csrf-token"]').attr('content') }
            },     
        "columns": [
            {data: 'id'},
            {data: 'kind_of_hc'},
            {data: 'call_time'},
            {data: 'kanban'},
            {data: 'shift'},
            {data: 'address'},
            {data: 'stock_boxes'},
            {data: 'stock_pcs'},
            {data: 'stock_min'},
            {data: 'actual_mros'},
            {data: 'plan_mros'},
            {data: 'type_of_material'},
            {data: 'place_of_material'},
            {data: 'note_to_write'},
            {data: 'boxes_for_delivery'},
            {data: 'boxes_delivered'},
            {data: 'boxes_before_delivery'},
            {data: 'delivery_boy'},
            {data: 'kbr_user'},
//            {data: 'tablet'},
            {data: 'status_tablet'},
            {data: 'sent_to_tablet'},
            {data: 'tablet_accepted'},
            {data: 'tablet_done'},
            {data: 'hotcall_finished'},
            {data: 'part_name'},
            {data: 'part_number'},
            {data: 'supplier_code'},
            {data: 'supplier_name'},
            {data: 'dock_code'},
            {data: 'box_type'},
            {data: 'course_stocker'},
            {data: 'course_deliver'},
            {data: 'course_picker'},
            {data: 'address_store'},
            {data: 'box_lot'},
            {data: 'line_side_capacity_requested'},
            {data: 'line_side_capacity_real'},
            {data: 'safety_boxes_line_side'},
            {data: 'safety_boxes_pc_store'},
            {data: 'hc_level'},
            {data: 'specialist_pc'},
            {data: 'build_out_yes_no'},
//            {data: 'build_out_date'},
//            {data: 'build_out_target'},
//            {data: 'ovf_yes_no'},
            {data: 'ovf_zone'},
            {data: 'ovf_number_of_boxes'},
            {data: 'ovf_number_of_boxes_cut_area'},
            {data: 'ovf_detailList'},
            {data: 'divert_yes_no'},
            {data: 'divert_problem_description'},
            {data: 'divert_instead_of_control'},
            {data: 'divert_implementatio_by'},
            {data: 'boxUsage'},
            {data: 'multiAddresses'},
            {data: 'list_of_models'},
        ],
        "order": [[ 2, "desc" ]],
        "buttons": ['excel','copy','csv','pdf','print'],
        "orderCellsTop": true,
        
        "colReorder": true,
        "scrollResize": true,
        "scrollX": true,
        "scrollY": '60vh',
        "scrollCollapse": true,
        
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 500, 1000, 5000, 10000], [10, 25, 50, 500, 1000, 5000, 10000]],
        
        oLanguage: {
        "sProcessing": "<img src='pictures/img_processing.gif'> Loading...",
        },

        initComplete: function(settings, json) {
            
                    
                     $('div.loading').attr("hidden", true);
                     $('div.loadingEnded').attr("hidden", false); 
                    //buttons
                    table.buttons( 0, null ).containers().appendTo( '#myButtonsPosition' );
        
          },
          
        } );
    
    
});
