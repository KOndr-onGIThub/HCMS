function data_ovf_kanban(kanban){
var API_data_ovf_kanban = $('#API_data_ovf_kanban').val();

 $.ajax({
    url: API_data_ovf_kanban + kanban + '/json/1',
    dataType: "json",
    method: 'get',
    success: function (data) {
//         console.log(data);

        if((data != 'null')) {  //&& (data != '')
            getOvfByKanban(data, kanban);
            
            highlightIfNoZerroOVF();
            
            addKbnToLegentOVF(kanban);
        }
                
            saveOvfTable();  // ulozit az budou vsechny data co potrebuju v teto tabulce nacteny
         
    },

    error: function(){
        alert('Nepodarilo se nacist data z aplikace "OVF". \n\n err.1');
        
    }
});
}

                    function getOvfByKanban(data, kanban){

                        let key;// polozka pro cyklus
                        let ovf = 0;
                        let cut = 0;
                        let ovfZone = 0;
                        let table = ''; // TADY BUDE HTML kod TABULKY
                        let listOfZones = '';
                        let sumOfOvf = 0;
                        let sumOfCut = 0;
                        let ovf_detailList = '';

                            for (key in data[kanban]){
//                                if (data[kanban].hasOwnProperty(key)){ //asi neni nutne
                                    ovf = data[kanban][key]['count'];
                                    cut = data[kanban][key]['cutted'];
                                    ovfZone = key;
//                                }

                                table += '<tr><td>' + ovfZone + '</td><td>' + ovf + '</td><td>' + cut + '</td></tr>';
                                
                                listOfZones += ovfZone + ', ';
                                sumOfOvf += ovf;
                                sumOfCut += cut;
                                ovf_detailList += 'OVF_' + ovfZone + '=' + ovf + 'b. ' ;
                            }
                                //to add hidden row with total info for DB table
                                table += '<tr hidden><td><input name="ovf_zone" value="' + listOfZones + '"/></td>\n\
                                        <td><input name="ovf_number_of_boxes" value="' + sumOfOvf + '"/></td>\n\
                                        <td><input name="ovf_number_of_boxes_cut_area" value="' + sumOfCut + '"/></td></tr>\n\
                                        <tr hidden><td colspan="3"><input name="ovf_detailList" value="' + ovf_detailList + '"/></td></tr>';
                                       
                                
                            
                            
                            $('#tbody_ovf').html(table);

                    }

                    //zvirazni bunky z nenulovou hodnotou
                    function highlightIfNoZerroOVF(){
                        
                        $("#ovf tr td").filter(function() {
                             if ($(this).text() != 0 ){
                                 $(this).addClass('hover_bck-gnd_1');
                             }
                        });
                        
                    }
                    
                    function addKbnToLegentOVF(kanban){
                        $('#OVFlegend').text('OVF kanabnu ' + kanban);
                    }


                    //ulozi html kod casti stranky - tabulky
                    function saveOvfTable(){
                        localStorage.ovfTable_content = $('#tbody_ovf').html();
                    }