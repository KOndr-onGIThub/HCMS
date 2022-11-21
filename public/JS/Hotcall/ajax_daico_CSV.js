//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function CsvDaicoData(kanban, dockType) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let ajaxUrl = $('#getCsvDaicoData').val(); // url je v tomto skritem inputu
    
    $.ajax({
        url: ajaxUrl,
        dataType: "json",
        method: 'get',
        success: function (data) {
//                 console.log(data);
 
                     for(let polozka in data){

                            let KPAkey = data[polozka]['KPA_KEY'];
                            let IKAkey = data[polozka]['IKA_KEY'];
                            let kbn = KPAkey.substr(0, 4);
                            
                                if(kbn === kanban){
                                    let picker = data[polozka]['PICKER'];
                                    
                                    let address1 = IKAkey.substr(4, 10); // odebrat kbn cislo
                                    address1 = address1.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID
                                    
                                        let realCapa1 = data[polozka]['REAL_CAPA'];
                                        let requestedCapa1 = data[polozka]['REQUESTED_CAPA'];
                                        let boxUsage1 = data[polozka]['BOX_MIN'];
                                        let safetyStock1 = data[polozka]['SAFETY_BOX'];
                                        let hcLevel1 = data[polozka]['HC_LEVEL'];
                                    
                                    
                                    let address2 = KPAkey.substr(4, 10); // odebrat kbn cislo
                                    address2 = address2.replace(/ /g, '').replace('/', '-'); //v adrese nahrazuji mezery a pak lomitka - nesmeji byt v ID

                                    var reqCapa = '';
                                    (dockType == 'PC-Store' ? reqCapa ='REQ_PC_CAPA' : reqCapa ='REQUESTED_CAPA');
                                    var realCapa = '';
                                    (dockType == 'PC-Store' ? realCapa ='REAL_PC_CAPA' : realCapa ='REAL_CAPA');
                                    var boxMin = '';
                                    (dockType == 'PC-Store' ? boxMin ='' : boxMin ='BOX_MIN');
                                    var safety = '';
                                    (dockType == 'PC-Store' ? safety ='SAFETY_PC_STORE' : safety ='SAFETY_BOX');
                                    var hcLevel = '';
                                    (dockType == 'PC-Store' ? hcLevel ='' : hcLevel ='HC_LEVEL');
                                    
                                        let realCapa2 = data[polozka][realCapa];
                                        let requestedCapa2 = data[polozka][reqCapa];
                                        let boxUsage2 = data[polozka][boxMin];
                                        let safetyStock2 = data[polozka][safety];
                                        let hcLevel2 = data[polozka][hcLevel];
                                    
                                                $('#picker_' + address1 ).text(picker); 
                                                $('#realCapa_' + address1 ).text(realCapa1);
                                                $('#requestedCapa_' + address1 ).text(requestedCapa1); 
                                                $('#boxUsage_' + address1 ).text(boxUsage1);
                                                $('#safetyStock_' + address1 ).text(safetyStock1); 
                                                $('#hcLevel_' + address1 ).text(hcLevel1);
                                            //pokud je KPA jina nez IKA, tak prepsat s KPA 
                                            if(address1 != address2){    
                                                $('#picker_' + address2 ).text(picker); 
                                                $('#realCapa_' + address2 ).text(realCapa2);
                                                $('#requestedCapa_' + address2 ).text(requestedCapa2); 
                                                $('#boxUsage_' + address2 ).text(boxUsage2);
                                                $('#safetyStock_' + address2 ).text(safetyStock2); 
                                                $('#hcLevel_' + address2 ).text(hcLevel2);
                                        // pozn. Nelamu si hlavu s tim jestli je to DA nebo direct, ale pripravim si vse pro obe moznosti, a ta nevyuzita se proste nespoji dle ID
                                        // Musim jen poresit situace, kdy jsou adresy stejne a mel bych 2 stejne ID. To by nefungovalo.
                                            }
                                }
                                
                    }
                    
                    saveAddressTable();

            },

            error: function(){
                alert('Nepodarilo se nacist data z tabulky daico_csv. \nZkontroluj KBN číslo a adresu. \n\n err.1');
//                clearDestroy2('refresh');
            }
    });
}






                    //ulozi html kod casti stranky - tabulky
                    function saveAddressTable(){
                        localStorage.addressTable_content = $('#tbody_adresy_zasoby').html();
                    }