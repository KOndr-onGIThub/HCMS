<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Tablet Selection.">
        <meta name="keywords" content="HC, hot call, hot call managemen system, tablet, selection">

        <link rel="shortcut icon" href="{{ asset('pictures/tablet_32x32.png') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/tabletScreen.css') . '?' . env('APP_VERSION') }}">


        <script src="{{ asset('JS/Library/jquery-3.4.1.min.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js'). '?' . env('APP_VERSION')  }}"></script>
        <script src="{{ asset('JS/Library/moment-with-locales.js') . '?' . env('APP_VERSION') }}"></script>


        <title>{{config('app.shortName')}}  - Tablet Selection</title>


    </head>

    <body style="background: black">
        <div style="padding-top: 10%;">
            <div class="selectTabletArea" style="background:LightYellow; margin:auto; position:relative;width:50%; height:50%; border:5px solid white; padding:10px; text-align:center; ">

                <h1>Vyberte tablet ...</h1>

                <span >
                    <!-- list of tablets available in DB -->
                    <select id="selectedTabletName" class="selectTabletArea" style="font-size: 200%">
                        <option>ZDE</option>
                        @foreach ($tabletsList as $tablet)
                        <option value="{{ $tablet->name }}">{{ $tablet->name }}</option>
                        @endforeach
                    </select>
                </span>

                <p style="font-style: italic">
                    * Budou se zobrazovat jen HotCally odeslané pracovníkem KanbanRoom na vybraný tablet.
                </p>

            </div>
        </div>
        
        <input type="hidden" id="tabletURL" value="{{ url('TabletScreen') }}"> <!-- abych mohl pouzit PHP funkci url / url je v tomto inputu -->
<!--        nasledujici input je zde jen pro to, ze pro tablet pouzivam stejny JS casovac jako pro stranku volani
        soucasti casovace je func_ajax_Data(url), ktera ale neni pro tablet vyuzita, nicmene pokud tuto funkci nenamapuju bude se v conzoli zobrazovat chyba-->
        <input type="hidden" id="HotcallData" value="{{ url('HotcallData') }}"> 
        

        <script src="{{ asset('JS/TabletScreen/tabletScreen.js').'?'.env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/Hotcall/actionsTime.js').'?'.env('APP_VERSION') }}"></script>
        <script src="{{ asset('JS/Hotcall/ajax_data.js').'?'. env('APP_VERSION') }}"></script>


    </body>
</html>
