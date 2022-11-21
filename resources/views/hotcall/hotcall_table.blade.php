    <div class='pro_TEST'>
            <td><label for="kbr_user">KBR</label>
                <select name="kbr_user" ID="kbr_user" class="saved">
                                <option value="1">KANBAN ROOM 1</option>
                                <option value="2">KANBAN ROOM 2</option>
                                <option value="3">KANBAN ROOM 3</option>
<!--                                <option value="2">test_Ondra2</option>
                                <option value="3">test_Ondra3</option>-->
                </select>
            </td>
    </div>

    <table>
        <tr>
            <td>
                <input id="call_time" class="" type="hidden" name="call_time">
            </td>

        </tr>
    </table>


    <table>
        <tr>
            <td><label for="shift">SMĚNA</label><br />
                <select ID="shift" class="saved inputWidth_100 inputHeight_100" name="shift">
                                <option id="A" value="A">A</option>
                                <option id="B" value="B">B</option>
                                <option id="C" value="C">C</option>
                </select>
           </td>
           
        <td class="inputWidth_40"></td>

        <td id="radio_pointers" class='radio inputWidth_140b'>        
                <label for="radio_HC" class="pointer">DÍL</label>
                    <input ID="radio_HC" class="saved destroy pointer" type="radio" name="kind_of_hc" value="DÍL" checked="checked"><br>
                <label for="radio_EB" class="pointer">Empty Box</label>
                    <input ID="radio_EB" class="saved destroy pointer" type="radio" name="kind_of_hc" value="Empty Box"><br>
                <label for="radio_mistake" class="pointer">Záměna</label>
                    <input ID="radio_mistake" class="saved destroy pointer" type="radio" name="kind_of_hc" value="Záměna"><br>
            </td>
            
            <td>
                    <label for="kanban">KBN</label><br>
                    <input ID="kanban" class="saved destroy inputWidth_200 inputHeight_80" type="text" name="kanban" placeholder="KBN" autofocus autocomplete="off">

            </td>
            
        <td class="inputWidth_10b"></td>
        
            <td>
                <label for="address">ADRESA</label><br>
                <!--<input ID="address" class="saved destroy inputWidth_350 inputHeight_55" type="text" name="address" placeholder="ADRESA" autocomplete="off">-->
                <select ID="address" class="saved destroy inputWidth_350 inputHeight_55" name="address">
                    <!--created in JS function getAddresses-->
                </select>
            </td>
        </tr>
    </table>


    <table>
        <thead>
            <tr>

                <td colspan='3' class='text_center '><label>ZÁSOBA ...</label></td>
                <td></td>
                <td colspan='2' class='text_center '><label>MROS ...</label></td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <!--<label for="">ZÁSOBA ...</label><br />-->
                    <label for="stock_box">... BOXŮ</label><br />
                        <input ID='stock_box' class="saved destroy inputWidth_150 inputHeight_70" type="text" name="stock_boxes" placeholder="BOX" autocomplete="off">
                </td>
                <td>
                    <label for="stock_pcs">... KUSŮ DÍLŮ</label><br />
                        <input ID='stock_pcs' class="saved destroy inputWidth_150 inputHeight_70" type="text" name="stock_pcs" placeholder="KS" autocomplete="off">
                </td>
                <td>
                    <label for="stock_min">... MINUT VÝROBY</label><br />
                        <input ID='stock_min' class="saved destroy inputWidth_150 inputHeight_70" type="text" name="stock_min" placeholder="MIN" autocomplete="off">
                </td>

            <td class="inputWidth_70"></td>

                <td>
                    <!--<label for="">MROS ...</label><br />-->
                    <label for="actual_mros">... AKTUÁLNÍ</label><br>
                    <input ID='actual_mros' class="saved destroy inputWidth_150 inputHeight_70" type="text" name="actual_mros" placeholder="AKT." autocomplete="off">
                </td>
                <td>
                    <label for="plan_mros">... PLÁNOVANÝ</label><br>
                        <input ID='plan_mros' class="saved destroy inputWidth_150 inputHeight_70" type="text" name="plan_mros" placeholder="PLÁN" autocomplete="off">
                </td>
            </tr>
        </tbody>
    </table>


    <table>
        <tr>
            <td><label for="whom_1">PŘEDAT</label></td>
            <td colspan='4' class='text_center'><label>INSTRUKCE</label></td>
        </tr>
            <tr>
                <td>
                        <select ID='whom_1' name="whom_1" size="10" class="saved destroy">
                            <optgroup label="Zařízení">
                                <option selected="selected" value="TABLET" >TABLET </option>
                                <option value="SMART PHONE" disabled>SMART PHONE </option>
                            </optgroup>
                            <optgroup label="TL/GL">
                                <option value="Deliver" >Deliver </option>
                                <option value="PC-store" >PC-store </option>
                                <option value="Final Dock" >Final Dock </option>
                                <option value="Dock" >Dock </option>
                            </optgroup>
                            <optgroup label="jiné">
                                <option value="jiný" >jiný </option>
                            </optgroup>
                        </select>
                        <select ID='delivery_boy' name="delivery_boy" size="5" class="saved destroy">
                            @foreach ($listOfTablets as $tablet)
                                @if ($loop->first)
                                    <option value=" {{ $tablet->name }} " selected="selected"> {{ $tablet->name }} </option>
                                @else                                                        
                                    <option value=" {{ $tablet->name }} " > {{ $tablet->name }} </option>
                                @endif
                            @endforeach
                        </select>
                </td>
                <td class='bottom'>
                    <label for="type_of_material" class=''>DRUH</label><br>
                        <select ID='type_of_material' name="type_of_material" size="7" class="saved destroy">
                            @foreach ($typeOfMaterials as $typeOfMaterial) 
                                <option value=" {{ $typeOfMaterial->type }} ">  {{ $typeOfMaterial->type }} </option>                      
                            @endforeach
                        </select>
                </td>
                <td class='bottom'>
                    <label for="place_of_material" class=''>ODKUD</label><br>
                        <select ID='place_of_material' name="place_of_material" size="7" class="saved destroy">
                            @foreach ($placeOfMaterials as $placeOfMaterial) 
                                    <option value=" {{ $placeOfMaterial->place }} "> {{ $placeOfMaterial->place }} </option>)                 
                            @endforeach
                        </select> 
                </td>
                <td class='bottom'>
                    <label for="note_to_write">DOPLŇUJÍCÍ POZNÁMKA</label><br />
                    <input ID='note_to_write' class="saved destroy inputHeight_70b inputWidth_350" name="note_to_write" placeholder="POZNÁMKA" autocomplete="off">
                </td>
                <td class='bottom'>
                    <label for="boxes_for_delivery">ZAVÉZT BOXŮ</label><br />
                        <input ID='boxes_for_delivery' class="saved destroy inputWidth_100 inputHeight_70" type="text" name="boxes_for_delivery" placeholder="ZAV." autocomplete="off">
                </td>
            </tr>

    </table>
