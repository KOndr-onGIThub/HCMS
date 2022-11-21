
<fieldset id="field_noFinished">
    <legend title=""><strong>NEUKONČENÉ HC</strong></legend> <!-- titulek je nastavovan v JS actionsTime --> 
        <table id='table_noFinished' border="1" width="870px">
            <thead>
                <tr>
                    <th title="kdy byl HC (kanbanové číslo) zadán">PŘIJATO</th>
                    <th title="kdy byl HC (kanbanové číslo) zadán">ČAS</th>
                    <th title="SMĚNA">SM.</th>
                    <th>KBN</th>
                    <th>ADRESA</th>
                    <th id="minutesToStop" title="">ZB. ČAS</th> <!-- titulek je nastavovan v JS actionsTime --> 
                    <th title="komu byl HC určen">KOMU</th>
                    <th title="HC označit jako UKONČENÝ=ZAVEZENÝ">UKONČIT</th>
                </tr>

            </thead>
            <tbody id="tbody_noFinished">
                @isset($hotcalls)
                     @for($i=0; $i<( $howManyHCNoFinished); $i++)
                        <tr id="rowNoFin_id_{{ $hotcalls[$i]['id'] }}">
                            <td id="noFin_id_{{$i}}" hidden="hidden">{{ $hotcalls[$i]['id'] }}</td>
                            <td id="noFin_startTime_{{$i}}" hidden="hidden">{{ $hotcalls[$i]['call_time'] }}</td>
                            <td id="noFin_stock_min_{{$i}}" hidden="hidden">{{ $hotcalls[$i]['stock_min'] }}</td>
                            
                            <td> {{ $prettyTimesNoFinished[$i] }} </td>
                            <td> {{ $normalTimesNoFinished[$i] }} </td>
                            <td>{{ $hotcalls[$i]['shift'] }} </td>
                            <td> {{ $hotcalls[$i]['kanban'] }} </td>
                            <td> {{ $hotcalls[$i]['address'] }} </td>
                            <td id="noFin_timeToStop_{{$i}}"></td>       <!-- JS actionsTime-->
                            <?php $style= 'style="background: orange" title="Oranžová barva znamená, že byl na tabletu odmáčknut start. Tento stav je kontrolován pouze při načtení této stránky"'; ?>
                            <td <?php if($hotcalls[$i]['status_tablet'] == 2 ){ echo($style);} ?>> {{ $hotcalls[$i]['delivery_boy'] }} </td>
                            <td> 
                                <button  id="noFin_btn_finish_{{$i}}" class="finish_HC" type="button">Ukončit</button>
                                <button  id="noFin_btn_loadForUpdate_{{$i}}" class="loadForUpdate" type="button" title="Aktualizovat tento HC">Aktual.</button>
                            </td>
                         </tr>
                     @endfor                        
                @endisset    
            </tbody>
        </table>
</fieldset>
<div id="dialogCloseHotcall" hidden="hidden" title="UKONČIT?">
    <p>OZNAČIT JAKO UKONČENÉ?</p>
    <p>PO POTVRZENÍ NELZE VRÁTIT ZPĚT!</p>
</div>
