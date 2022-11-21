function data_redPost(){
var API_redpost = $('#API_redpost').val();

 $.ajax({
    url: API_redpost,
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);
 

 
        if((data != 'null') ){ //&& (data != '')
            getRedPost(data);
            
            highlightIfNoZerroRedPost();
        }
                
            saveRedPostTable();  // ulozit az budou vsechny data co potrebuju v teto tabulce nacteny
         
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "Red Post". \n\n err.1');
        
    }
});
}

                    function getRedPost(data){
                        let key;// polozka pro cyklus
                        let table = ''; // TADY BUDE HTML TABULKY
                        let rp_num = 0; // number of red post
                        let ua_num = 0; // number of unattainable
                        let sm_num = 0; // number of stocker mistake
                        let cl_num = 0; // number of cannot load box

                            for (key in data){
//                                if (data[kanban].hasOwnProperty(key)){ //asi neni nutne
//                                    console.log(key);
                                    
                                    switch( data[key][1] ){
                                        case 1:  //RED POST
                                            rp_num += 1;
                                         break;
                                        case 2: //NEDOSAŽITELNÝ (nedostupný)
                                            ua_num += 1;
                                         break;
                                        case 3:  //CHYBA STOCKER
                                            sm_num += 1;
                                         break;
                                        case 4: //NELZE NALOŽIT (plná kapacita dolly)
                                            cl_num += 1;
                                         break;
                                        default:

                                    }  
//                                }
                            }


                            table = '<tr><td>' + rp_num + '</td><td>' + ua_num + '</td><td>' + sm_num + '</td><td>' + cl_num + '</td></tr>';
                            
                            $('#tbody_redpost').html(table);
                    }


                    
                    //zvirazni bunky z nenulovou hodnotou
                    function highlightIfNoZerroRedPost(){
                        
                        $("#tbody_redpost tr td").filter(function() {
                             if ($(this).text() != 0 ){
                                 $(this).addClass('hover_bck-gnd_1');
                             }
                        });
                        
                    }



                    //ulozi html kod casti stranky - tabulky
                    function saveRedPostTable(){
                        localStorage.redPostTable_content = $('#tbody_redpost').html();
                    }
