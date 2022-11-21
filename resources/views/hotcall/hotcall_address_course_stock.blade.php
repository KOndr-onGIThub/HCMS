        <div id='infoPart' >
            <fieldset>
                <legend title="detaily nejsou k dispozici">
                
                    <span id="spanADRpref"> 
                    <strong>ADRESY & ZÁSOBY</strong> 
                        <span title='PODLE TOHOTA DATA SE HLEDAJI PLATNÉ ADRESY'> 
                            <input ID="ADR_year" class="inputWidth_70 inputHeight_25" type="number" name="" placeholder="RRRR" value="" autocomplete="off" >
                            <input ID="ADR_month" class="inputWidth_40 inputHeight_25" type="number" name="" placeholder="MM" value="" autocomplete="off" >
                            <input ID="ADR_day" class="inputWidth_40 inputHeight_25" type="number" name="" placeholder="DD" value="" autocomplete="off" >

                            <input id="ADRpref" class="saved" type="checkbox" name="ADRpref" value=""> <span>Vlastní</span>
                        </span>
                   </span>
                
                </legend>
                    <table id='adresy_zasoby' border="1" width="570">
                        <thead>
                            <tr> 
                                <th rowspan="2">*ADRESA*</th>
                                <th colspan="3" title="Kuryz yobrayované na kanbanech">KURZ</th>
                                <th colspan="2" title="Kapacita v boxech">KAPACITA</th>
                                <th rowspan="2" title="Kolik minut V PRŮMĚRU trvá spotřeba 1 boxu na dané adrese">1 Box USAGE</th>
                                <th rowspan="2" title="V boxech stanovená minimální/bezpečnostní zásoba na dané adrese dle Daiča">SAFETY zásoba</th>
                                <th rowspan="2" title="Při kolika boxech by měl být volán HC dle Daiča">HC LEVEL</th>
                            </tr>
                            <tr>
                                <th title="Kurz na externím kanbanu">EXT.</th>
                                <th title="Kurz na interním kanbanu">INT.</th>
                                <th title="Picker kurz dle Daiča">PIC.</th>
                                <th title="Reálná kapacita dle Daiča">Reálná</th>
                                <th title="Požadovaná kapacita dle Daiča">Požad.</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_adresy_zasoby">
                            <!-- see JS -->
                            
                        </tbody>
                        
                    </table>
            </fieldset>
        </div>