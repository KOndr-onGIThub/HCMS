@extends('history/history_layout')

@section('title', config('app.shortName')  . ' - Historie')

@section('content')

<div class="loading">
    <img src="{{ asset('pictures/img_processing.gif') }}"/>
</div>

<div class="loadingEnded" hidden="hidden">

    <div id="myButtonsPosition"></div>

    <div>
        
        

        <table id='historyTable' class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DRUH VOLÁNÍ</th>
                    <th>ČAS VOLÁNÍ</th>
                    <th>KBN</th>
                    <th>SMĚNA</th>
                    <th>ADRESA</th>
                    <th>ZÁSOBA BOXŮ</th>
                    <th>ZÁSOBA KS</th>
                    <th>ZÁSOBA minut</th>
                    <th>MROS AKTUAL</th>
                    <th>MROS PLÁN</th>
                    <th>DRUH MATERIALU</th>
                    <th>ODKUD</th>
                    <th>DOPLŇUJÍCÍ POZNÁMKA</th>
                    <th>ZAVÉZT BOXŮ</th>
                    <th>ZAVEZENO BOXŮ</th>
                    <th>BOXŮ PŘED ZÁVOZEM</th>
                    <th>ZAVEZL</th>
                    <th>KBR UŽIVATEL</th>
                    <!--<th>TABLET</th>-->
                    <th>status tablet (2=accepted 3=done)</th>
                    <th>odesláno na tablet</th>
                    <th>akceptováno na tabletu</th>
                    <th>ukončeno na tabletu</th>
                    <th>HC ukončen</th>
                    <th>Název dílu</th>
                    <th>Číslo dílu</th>
                    <th>kód dodavatele</th>
                    <th>název dodavatele</th>
                    <th>dock kód</th>
                    <th>box type</th>
                    <th>kurz extrení kanban</th>
                    <th>kurz interní kanban</th>
                    <th>kurz picker</th>
                    <th>adresa PC-Store</th>
                    <th>box lot</th>
                    <th>line side capacity Požadovaná</th>
                    <th>line side capacity Reálná</th>
                    <th>safety boxes line side</th>
                    <th>safety boxes PC-Store</th>
                    <th>HC level</th>
                    <th>specialista PC</th>
                    <th>build/out yes no</th>
<!--                    <th>build/out date</th>
                    <th>build/out target</th>
                    <th>ovf yes no</th>-->
                    <th>ovf zone</th>
                    <th>ovf počet boxů</th>
                    <th>ovf počet boxů cut area</th>
                    <th>seznam OVF zon s pocty boxů</th>
                    <th>divert yes no</th>
                    <th>divert popis problému</th>
                    <th>divert place of control</th>
                    <th>divert implementatio by</th>
                    <th>1 Box usage</th>
                    <th>multi Addresses</th>
                    <th>list of models</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>   
    </div>
    
</div>
    
@endsection

