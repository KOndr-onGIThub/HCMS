<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Hot Call solution.">
        <meta name="keywords" content="HC, hot call, hot call managemen system">

        <link rel="shortcut icon" href="{{ asset('pictures/tablet_32x32.png') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/tabletScreen.css').'?'. env('APP_VERSION') }}">


        <script src="{{ asset('JS/Library/jquery-3.4.1.min.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/Library/moment-with-locales.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/TabletScreen/clipboard.js') . '?' . env('APP_VERSION') }}"></script>

        <video id="myvideo" width="1" height="1" autoplay muted loop>
            <source src="../video/movie.mp4" type="video/mp4"/>
            Your browser does not support the video tag.
        </video>

        <audio id="alarm">
            <source src="{{ asset('\sounds\kohout.mp3') }}">
        </audio>

        <title>{{config('app.shortName')}} - Tablet</title>


<!--        <video id="myvideo" width="1" height="1" autoplay muted loop>
            <source src="{{ asset('video/movie.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>-->


    </head>

    <body>
        <div id="header" style="background: lightblue; margin: auto; padding:5px; position:relative; font-size: 130%">
            <form action="{{ asset('TabletScreen') }}">
                <span>
                    <span>Zobrazeny HotCally pro tablet: </span>
                    <span><button type="submit" style="font-weight:bold; font-size: 130%"> {{$tabletName}}</button></span>
                </span>
<!--                <button type="submit"  id="backToTabletSelection" title="Zpět na výběr tabletu">Zvolit jiný tablet</button>-->

                <button type="button" id="btnShowKanbanPickingDialog" style="font-size: 130%">Sběr kanbanů</button>
            </form>
        </div>
        <div id="divTabletContentContainer">
            <div class="divTableHotcallHeader">
                <h2>Nevyřízené hotcally
                    <span id="spanBatteryStatus" class="fontRed"> </span>
                </h2>
            </div>

            <div id="divTblHotcall">
                <table id="tblHotcall">
                    <thead>
                        <tr>
                            <th title="kdy byl HC (kanbanové číslo) zadán">PŘIJATO</th>
                            <th title="kdy byl HC (kanbanové číslo) zadán">ČAS</th>
                            <th>Kanban</th>
                            <th>L/S Address</th>
                            <th>INSTRUKCE</th>
                            <th>MROS v čase HC</th>
                            <th>MROS plán</th>
                            <th>Počet boxů</th>
                            <th>ZBYTEK ČASU [min]</th>
                            <th>Divert</th>
                            <th width="110">
                                <span id="spanNewHotcallAlert" hidden>
                                    <img src="{{ asset('pictures/exclamation_mark_red.png') }}" height="35">
                                    nový HC
                                </span>
                            </th>
                        </tr>
                    </thead>

                    @if(isset($lastHC_ID))
                    <span id="lastHC_ID" hidden> {{$lastHC_ID['id']}} </span>
                    @else
                    <span id="lastHC_ID" hidden> 0 </span>
                    @endif

                    <tbody id="tbody_noFinishedTablet">
                        @isset($hotcalls)
                             @for($i=0; $i<( $howManyHCNoFinished); $i++)
                                <tr id="rowNoFin_id_{{ $hotcalls[$i]['id'] }}">
                                    <td id="noFin_startTime_{{$i}}" hidden>{{ $hotcalls[$i]['call_time'] }}</td>
                                    <td id="noFin_stock_min_{{$i}}" hidden>{{ $hotcalls[$i]['stock_min'] }}</td>
                                    <td id="noFin_id_{{ $hotcalls[$i]['id'] }}" hidden>{{ $hotcalls[$i]['id'] }}</td>
                                    <td id="noFin_status_{{ $hotcalls[$i]['id'] }}" hidden>{{ $hotcalls[$i]['status_tablet'] }}</td>
                                    <td> {{ $prettyTimesNoFinished[$i] }} </td>
                                    <td> {{ $normalTimesNoFinished[$i] }} </td>
                                    <td id="tdKanban_{{ $hotcalls[$i]['id'] }}" class="tdKanban"> {{ $hotcalls[$i]['kanban'] }} </td>
                                    <td> {{ $hotcalls[$i]['address'] }} </td>
                                    <td>
                                        <div><strong>Co:</strong>{{ $hotcalls[$i]['type_of_material'] }} </div>
                                        <div><strong>Odkud:</strong>{{ $hotcalls[$i]['place_of_material'] }} </div>
                                        <div><strong>pozn.:</strong>{{ $hotcalls[$i]['note_to_write'] }} </div>
                                    </td>
                                    <td> {{ $hotcalls[$i]['actual_mros'] }} </td>
                                    <td> {{ $hotcalls[$i]['plan_mros'] }} </td>
                                    <td> {{ $hotcalls[$i]['boxes_for_delivery'] }} </td>
                                    <td id="noFin_timeToStop_{{$i}}"></td>       <!-- JS actionsTime-->
                                    <td> {{ ($hotcalls[$i]['divert_yes_no'])=== '1' ? "ANO" : "NE" }} </td>
                                    <td>
                                        <button type="button" id="noFin_tabletBtn_{{ $hotcalls[$i]['id'] }}" class="status_HC finish_HC">
                                            @if($hotcalls[$i]['status_tablet'] === 2) <!-- 2 = solution started -->
                                                <span>KONEC</span>
                                            @else
                                                <span>START</span>
                                            @endif
                                        </button>
                                    </td> <!-- for button -->
                                    <!-- for detail dialog -->
                                    <td hidden id="tdSupplierName_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['supplier_name'] }}</td>
                                    <td hidden id="tdMultiaddress_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['multiAddresses'] }}</td>
                                    <td hidden id="tdSupplierCode_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['supplier_code'] }}</td>
                                    <td hidden id="tdBoxUsage_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['boxUsage'] }}</td>
                                    <td hidden id="tdBoxSize_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['box_type'] }}</td>
                                    <td hidden id="tdBoxLot_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['box_lot'] }}</td>
                                    <td hidden id="tdDeliveryCourse_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['course_stocker'] .' / '. $hotcalls[$i]['course_deliver'] .' / '. $hotcalls[$i]['course_picker']  }}</td>
                                    <td hidden id="tdPcStoreAddress_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['address_store'] ? $hotcalls[$i]['address_store'] : '-' }}</td>
                                    <td hidden id="tdOverflowZone_{{ $hotcalls[$i]['id'] }}" >{{ $hotcalls[$i]['ovf_zone'] ? $hotcalls[$i]['ovf_zone'] : '-' }}</td>
                                    <td hidden id="tdBoxCountInOverflow_{{ $hotcalls[$i]['id'] }}" >
                                        {{ $hotcalls[$i]['ovf_detailList'] ?  $hotcalls[$i]['ovf_detailList'] . ' ' : 'OVF= 0b. ' }}<br>
                                        {{ $hotcalls[$i]['ovf_number_of_boxes_cut_area'] ? ' CUT=' . $hotcalls[$i]['ovf_number_of_boxes_cut_area'] : 'CUT= 0b. ' }}
                                    </td>
                                 </tr>
                             @endfor
                        @endisset
                    </tbody>
                </table>
            </div>

            <div id="divLastHotcallHeader" class="divTableHotcallHeader">
                <h2>Poslední vyřízené hotcally</h2>
            </div>

            <table id="tblLastHotcall">
                <thead>
                <tr>
                    <th>Datum a čas ukončení</th>
                    <th>Kanban</th>
                    <th>L/S Address</th>
                    <th>Kde hledat</th>
                    <th>Akt. MROS</th>
                    <th>Plán MROS</th>
                    <th>Počet zavezených boxů</th>
                    <th>Počet boxů před závozem</th>
                    <!--<th width="110"></th>-->
                </tr>
                </thead>
                <tbody>
                    @isset($lastHotcalls)
                        @for($i=0; $i< min( 3,count($lastHotcalls) ); $i++)
                           <tr>
                               <td> {{ $prettyTimesTablet_done[$i] }} {{ $normalTimesTablet_done[$i] }} </td>
                               <td id="tdKanban_{{ $lastHotcalls[$i]['id'] }}" class="tdKanban"> {{ $lastHotcalls[$i]['kanban'] }} </td>
                               <td> {{ $lastHotcalls[$i]['address'] }} </td>
                               <td>
                                   <div><strong>Co:</strong>{{ $lastHotcalls[$i]['type_of_material'] }} </div>
                                   <div><strong>Odkud:</strong>{{ $lastHotcalls[$i]['place_of_material'] }} </div>
                                   <div><strong>pozn.:</strong>{{ $lastHotcalls[$i]['note_to_write'] }} </div>
                               </td>
                               <td> {{ $lastHotcalls[$i]['actual_mros'] }} </td>
                               <td> {{ $lastHotcalls[$i]['plan_mros'] }} </td>
                               <td> {{ $lastHotcalls[$i]['boxes_delivered'] }} </td>
                               <td> {{ $lastHotcalls[$i]['boxes_before_delivery'] }} </td>
                               <!--<td></td>  for button -->
                                    <!-- for detail dialog -->
                                    <td hidden id="tdSupplierName_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['supplier_name'] }}</td>
                                    <td hidden id="tdMultiaddress_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['multiAddresses'] }}</td>
                                    <td hidden id="tdSupplierCode_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['supplier_code'] }}</td>
                                    <td hidden id="tdBoxUsage_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['boxUsage'] }}</td>
                                    <td hidden id="tdBoxSize_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['box_type'] }}</td>
                                    <td hidden id="tdBoxLot_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['box_lot'] }}</td>
                                    <td hidden id="tdDeliveryCourse_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['course_stocker'] .' / '. $lastHotcalls[$i]['course_deliver'] .' / '. $lastHotcalls[$i]['course_picker']  }}</td>
                                    <td hidden id="tdPcStoreAddress_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['address_store'] ? $lastHotcalls[$i]['address_store'] : '-' }}</td>
                                    <td hidden id="tdOverflowZone_{{ $lastHotcalls[$i]['id'] }}" >{{ $lastHotcalls[$i]['ovf_zone'] ? $lastHotcalls[$i]['ovf_zone'] : '-' }}</td>
                                    <td hidden id="tdBoxCountInOverflow_{{ $lastHotcalls[$i]['id'] }}" >
                                        {{ $lastHotcalls[$i]['ovf_number_of_boxes'] ? 'OVF='. $lastHotcalls[$i]['ovf_number_of_boxes'] . ' ' : 'OVF=0 ' }}
                                        {{ $lastHotcalls[$i]['ovf_number_of_boxes_cut_area'] ? ' CUT=' . $lastHotcalls[$i]['ovf_number_of_boxes_cut_area'] : 'CUT=0' }}
                                    </td>
                            </tr>
                        @endfor
                    @endisset
                </tbody>
            </table>
        </div>


        <div id="divKeyboardDlg" data-hotcallid="" hidden>
            <div>
                <h1>Počet zavezených boxů</h1>
                <table id="tblKeyboardDelivered" data-tbltype="delivered">
                    <tbody>
                        <tr>
                            <td colspan="2" id="tdDisplayDelivered"></td>
                            <td class="tdKey tdDelete">SMAŽ</td>
                        </tr>
                        <tr>
                            <td class="tdKey">7</td>
                            <td class="tdKey">8</td>
                            <td class="tdKey">9</td>
                        </tr>
                        <tr>
                            <td class="tdKey">4</td>
                            <td class="tdKey">5</td>
                            <td class="tdKey">6</td>
                        </tr>
                        <tr>
                            <td class="tdKey">1</td>
                            <td class="tdKey">2</td>
                            <td class="tdKey">3</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="tdKey">0</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <h1>Počet zbývajících boxů</h1>
                <table id="tblKeyboardRemaining" data-tbltype="remaining">
                    <tbody>
                        <tr>
                            <td colspan="2" id="tdDisplayRemaining"></td>
                            <td class="tdKey tdDelete">SMAŽ</td>
                        </tr>
                        <tr>
                            <td class="tdKey">7</td>
                            <td class="tdKey">8</td>
                            <td class="tdKey">9</td>
                        </tr>
                        <tr>
                            <td class="tdKey">4</td>
                            <td class="tdKey">5</td>
                            <td class="tdKey">6</td>
                        </tr>
                        <tr>
                            <td class="tdKey">1</td>
                            <td class="tdKey">2</td>
                            <td class="tdKey">3</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="tdKey">0</td>
                            <td class="tdKey">.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="divKeyboardButtons">
                <span id="spanKeyboardBack" class="roundBorder">ZPĚT</span>
                <span id="spanKeyboardOk" class="roundBorder">OK</span>
            </div>
        </div>

        <div id="divDlgDetail" hidden>
            <div id="divKanbanDetailHeader">KANBAN <span id="spanKanban"></span></div>
            <table id="tblKanbanDetail">
                <tbody>
                    <tr>
                        <td>DODAVATEL</td>
                        <td id="tdSupplierName"></td>
                        <td></td>
                        <td>MULTIADRESA</td>
                        <td id="tdMultiaddress"></td>
                    </tr>
                    <tr>
                        <td>KÓD DODAVATELE</td>
                        <td id="tdSupplierCode"></td>
                        <td></td>
                        <td>USAGE (1box/min)</td>
                        <td id="tdBoxUsage"></td>
                    </tr>
                    <tr>
                        <td>VELIKOST BOXU</td>
                        <td id="tdBoxSize"></td>
                        <td></td>
                        <td>BOX LOT</td>
                        <td id="tdBoxLot"></td>
                    </tr>
                    <tr>
                        <td>EXT./INT./PIC.</td>
                        <td id="tdDeliveryCourse"></td>
                        <td></td>
                        <td>ADRESA PC-STORU</td>
                        <td id="tdPcStoreAddress"></td>
                    </tr>
                    <tr>
                        <td>ZÓNA OVERFLOW</td>
                        <td id="tdOverflowZone"></td>
                        <td></td>
                        <td>POČET BOXŮ V OVERFLOW</td>
                        <td id="tdBoxCountInOverflow"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><div id="divDialogCloseButton" class="roundBorder">ZAVŘÍT</div></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="divDlgKanbanPicking" hidden>
            <?php
            $placeName1 = "DOW-3";
            $placeName2 = "EG2S-11";
            $placeName3 = "F1E-23";
            $placeName4 = "EGS-8";
            $placeName5 = "F2W-5";
            $placeName6 = "CHN-9";
            $placeName7 = "F2W-6 Battery";
            $placeName8 = "TRS-24";
            $placeName9 = "F2W-8";
            $placeName10 = "TRS-14";
            $placeName11 = "F2W-14";
            $placeName12 = "CHN-25";
            $placeName13 = "F1E-9";
            $placeName14 = "TRS-8";
            $placeName15 = "F1E-4";
            $placeName16 = "KRANK-1/INSPE";
            $placeName17 = "";
            $placeName18 = "";
            $placeName19 = "";
            ?>
            <h2>DENNÍ PŘEHLED SEBRANÝCH KANBANŮ</h2>
            <h3 style="color: red">NA TÉTO STRÁNCE NEBUDETE UPOZORNĚNI NA NOVÝ HOTCALL !!</h3>
            <table id="tblKanbanPicking">
                <tbody id="bodyKanbanPicking">
                    <tr>
                        <td></td>
                        <td rowspan="11"><span class="tdRotate">S<br>E<br>K<br>C<br>E<br> <br>B<br></span></td>
                        <td colspan="4">ČASY SBĚRŮ</td>
                        <td rowspan="14">&nbsp;&nbsp;&nbsp;</td>
                        <td></td>
                        <td rowspan="14"><span class="tdRotate">S<br>E<br>K<br>C<br>E<br> <br>A<br></span></td>
                        <td colspan="4">ČASY SBĚRŮ</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Adresa sběru</td>
                        <td>7:00</td>
                        <td>9:00</td>
                        <td>11:00</td>
                        <td>13:30</td>
                        <td rowspan="2">Adresa sběru</td>
                        <td>7:00</td>
                        <td>9:00</td>
                        <td>11:00</td>
                        <td>13:30</td>
                    </tr>
                    <tr>
                        <td>16:30</td>
                        <td>18:30</td>
                        <td>21:00</td>
                        <td>23:00</td>
                        <td>16:30</td>
                        <td>18:30</td>
                        <td>21:00</td>
                        <td>23:00</td>
                    </tr>
                    <tr>
                        <td><?= $placeName1 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName1) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName1) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName1) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName1) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName2 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName2) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName2) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName2) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName2) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName3 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName3) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName3) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName3) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName3) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName4 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName4) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName4) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName4) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName4) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName5 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName5) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName5) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName5) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName5) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName6 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName6) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName6) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName6) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName6) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName7 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName7) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName7) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName7) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName7) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName8 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName8) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName8) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName8) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName8) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName9 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName9) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName9) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName9) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName9) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName10 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName10) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName10) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName10) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName10) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName11 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName11) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName11) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName11) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName11) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName12 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName12) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName12) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName12) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName12) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName13 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName13) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName13) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName13) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName13) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName14 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName14) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName14) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName14) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName14) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName15 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName15) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName15) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName15) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName15) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                        <td><?= $placeName16 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName16) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName16) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName16) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName16) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td class="noBorder" colspan="6" rowspan="3">
                            <button id="btnClearKanbanPicking" type="button"><h1>Vymazat vše</h1></button>
                        </td>
                        <td><?= $placeName17 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName17) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName17) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName17) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName17) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName18 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName18) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName18) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName18) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName18) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                    <tr>
                        <td><?= $placeName19 ?></td>
                        <td id="<?= str_replace(" ", "_", $placeName19) ?>_1" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName19) ?>_2" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName19) ?>_3" class="tdKanbanPickingStatus" data-status=""></td>
                        <td id="<?= str_replace(" ", "_", $placeName19) ?>_4" class="tdKanbanPickingStatus" data-status=""></td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>


<!--        <div id="dialogChangeStatus" hidden="hidden" title="POKRAČOVAT?">
            <p>POKRAČOVAT V ŘEŠENÍ HOT CALLU?</p>
        </div>-->


        <input type="hidden" id="statusChange" value="{{ url('statusChange') }}"> <!-- abych mohl pouzit PHP funkci url / url je v tomto inputu -->

        <!-- to remember values befor dialog will be opened -->
        <input type="hidden" id="solvedId" value="">
        <input type="hidden" id="solvedstatus" value="">
<!--        nasledujici input je zde jen pro to, ze pro tablet pouzivam stejny JS casovac jako pro stranku volani
        soucasti casovace je func_ajax_Data(url), ktera ale neni pro tablet vyuzita, nicmene pokud tuto funkci nenamapuju bude se v conzoli zobrazovat chyba-->
        <input type="hidden" id="HotcallData" value="{{ url('HotcallData') }}"> 



        <script src="{{ asset('JS/TabletScreen/tabletScreen.js').'?'. env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/Hotcall/actionsTime.js').'?'. env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/Hotcall/ajax_data.js').'?'. env('APP_VERSION') }}"></script>
        <!--<script src="{{ asset('JS/TabletScreen/hotcallUpdate.js').'?'. env('APP_VERSION') }}"></script>-->


    </body>
</html>
