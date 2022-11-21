//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function DockData(kanban) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let ajaxUrl = $('#getDockData').val(); // url je v tomto skritem inputu
    
    $.ajax({
        url: ajaxUrl,
        dataType: "json",
        method: 'get',
        success: function (data) {
//                 console.log(data);
                 
                    var kanban=$('#kanban');
                    var dockLookedFor = $('#dockCode').val();
                    var dockType = '';
 
                     for(let polozka in data){
                        
                        
                        if( data[polozka]['dock'] == dockLookedFor ){
                            dockType = data[polozka]['sort_of_1'];
                        };
                           
                    }
                        
                    
                    data_divert_ILSS(kanban.val(), dockType, dockLookedFor);
                    
                    

            },

            error: function(){
                alert('Nepodarilo se nacist data z tabulky dock_codes. \nInformujte administratora aplikace. \n\n err.1');
//                
            }
    });
}

