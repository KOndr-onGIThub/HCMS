// zavola controller pro zjisteni jestli jiz neni HC na dany kanban mezi neukoncenymi
function ajax_reoccurHC(url, kbn){
 $.ajax({
    url: url + '/' + kbn,
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);

        if((data[0] === 'YES')) {
            $('#kanban').addClass('reoccurHC');
            alert('HC NA TENTO DÍL JE MEZI NEUKONČENÝMI');
        }else{
            $('#kanban').removeClass('reoccurHC');
        }
                
         
    },

    error: function(){
        alert('Nepodarilo se nacist data z ajax_reoccurHC.js. \n\n err.1');
        
    }
});
}

            
         