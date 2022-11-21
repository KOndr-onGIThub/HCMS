// pro to aby JS pomoci ajaxu zjistil jestli uz ne/byl HC ukoncen (HotcallController.php & actionsTime.js & ajax_data.js)
function func_ajax_Data(url){
 $.ajax({
    url: url,
    dataType: "json",
    method: 'get',
    success: function (data) {
         //console.log(data);

        if((data != '')) {
        
            for (i = 0; i < data.length; i++) {
                let thisElement = $('#rowNoFin_id_' + data[i]['id']);
                if(thisElement){
                    thisElement.attr('hidden', 'hidden');
                }
            }  
        }
                
         
    },

    error: function(){
        alert('Nepodarilo se nacist data z ajax_data.js. \n\n err.1');
        
    }
});
}

            
         