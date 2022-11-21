<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <link rel="shortcut icon" href="{{ asset('pictures/call_32x32.png') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/hotcall.css') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/inputs.css') . '?' . env('APP_VERSION') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui-1.12.1/jquery-ui.min.css') . '?' . env('APP_VERSION') }}">
        
        <script src="{{ asset('js/Library/jquery-3.4.1.min.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('js/Library/moment-with-locales.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('js/Library/savy.min.js') . '?' . env('APP_VERSION') }}"></script>
        
        <title>@yield('title', 'HCMS')</title>
        
    </head>
    <body>
        
       
        <header id='header'>
                    @include('header_layout')
                    
                    <h1 class="title"> {{ config('app.name') }} - VOLÁNÍ</h1>
        </header>

<div id="test">


</div>


        <form id="form_HC" method="POST">
        @csrf
                <div class='section_1'>
                    @include('hotcall.hotcall_table')

                    <button id='destroy' class="btn_delete" type="button" title="VYPRÁZDNIT FORMULÁŘ">VYPRÁZDNIT</button>

<!--tlacitko pro odeslani bude ovlivneno dle uzivatelske role v aplikaci rolman-->
@php
$role_1="admin";
$role_2="log_kbr";
$role_3="log_leaders";
        // jelikoz zobrazeni teto stranky je jiz podmineno spadat do nejaké kategorie, tak zde uz neresim situaci kdy role je null
    if(in_array($role_1, Auth::user()->getARoles()) || in_array($role_2, Auth::user()->getARoles()) || in_array($role_3, Auth::user()->getARoles()) ) {
        $btnsnd = '<button id="send" class="btn_sent" type="submit" title="ODESLAT FORMULÁŘ">ODESLAT</button>';
    }else{
        $btnsnd ='<button id="send" class="btn_sent" type="button" title="Opravnění mají pouze ' .$role_1. ', ' .$role_2. ' a ' .$role_3. '">NEJSTE OPRAVNEN ODESLAT HC</button>';
    }
@endphp
{!! $btnsnd !!}

                    <button hidden="hidden" id="btn_update" class="btn_update" type="button" title="AKTUALIZOVAT INFORMACE K HOT CALLU">AKTUALIZOVAT</button>
                    <input id="idForUpdateINFO" hidden="hidden" name="idForUpdateINFO" value=""> <!-- for safe of id of record which I will want to update -->
                    @include('hotcall.hotcall_noFinished')
                    

                </div>

                <div class='section_2'>
                     @include('hotcall.hotcall_divert')

                     @include('hotcall.hotcall_basicInfo')
                     
                     @include('hotcall.hotcall_orderSummary')
                     
                     @include('hotcall.hotcall_ovf_and_redpost')

                     @include('hotcall.hotcall_address_course_stock')
                     
                     
                 
                    
                </div> 
        
                <!-- skryta pole pro sebrani urcitych dat do DB
                Jde o data ktera jsou ziskavana pomoci JS a dalsi JS je pak vybere dle dalsich akci jako actionsAddress.js
                -->
                <div id="hidenSecondaryData">
                    <input type="hidden" id='course_stocker' name="course_stocker" value="">  <!-- sem vlozim javascriptem hodnotu, kterou budu pri odeslani formulare ukladat do databaze -->
                    <input type="hidden" id='course_picker' name="course_picker" value="">
                    <input type="hidden" id='course_deliver' name="course_deliver" value="">
                    <input type="hidden" id='address_store' name="address_store" value="">
                    <input type="hidden" id='line_side_capacity_requested' name="line_side_capacity_requested" value="">
                    <input type="hidden" id='line_side_capacity_real' name="line_side_capacity_real" value="">
                    <input type="hidden" id='safety_boxes_line_side' name="safety_boxes_line_side" value="">
                    <input type="hidden" id='safety_boxes_pc_store' name="safety_boxes_pc_store" value="">
                    <input type="hidden" id='hc_level' name="hc_level" value="">
                    <input type="hidden" id="multiAddresses" name="multiAddresses" value="">
                    <input type="hidden" id="boxUsage" name="boxUsage" value="">
                </div>
        </form>    
                    

                    
            <div class="section_3">
                 @include('hotcall.hotcall_history')
            </div>     

        <!--zrušit obtékání-->
        <div class="clearFloat"></div>

       
        
        <input type="hidden" id="getCsvDaicoData" value="{{ url('getCsvDaicoData') }}">  <!-- abych mohl pouzit PHP funkci url / url je v tomto inputu -->
        <input type="hidden" id="HotcallFinished" value="{{ url('HotcallFinished') }}">
        <input type="hidden" id="HotcallData" value="{{ url('HotcallData') }}">
        <input type="hidden" id="reoccurHotcall" value="{{ url('reoccurHotcall') }}">
        <!--<input type="hidden" id="url_storeDaico" value="{{ url('csvDaico') }}">-->
        <input type="hidden" id="getDockData" value="{{ url('getDockData') }}">
        <input type="hidden" id="getDataForUpdate" value="{{ url('Hotcall/find') }}">
        <input type="hidden" id="getDataForUpdateINFO" value="{{ url('Hotcall') }}">
        <input type="hidden" id="getModelToyota" value="{{ url('getModelToyota') }}">
        <input type="hidden" id="getCsvPartrqdbData" value="{{ url('getCsvPartrqdbData') }}">
        
        <input type="hidden" id="API_getDivertData" value="{{ env("API_getDivertData", "somedefaultvalue") }}">  <!-- URL's for API, the URL's are defined in .env for each environment differently-->
        <input type="hidden" id="API_getOrderSummaryData" value="{{ env("API_getOrderSummaryData", "somedefaultvalue") }}">
        <input type="hidden" id="API_getDaicoData" value="{{ env("API_getDaicoData", "somedefaultvalue") }}">
        <input type="hidden" id="API_getPartByKanban" value="{{ env("API_getPartByKanban", "somedefaultvalue") }}">
        <input type="hidden" id="API_getDivert" value="{{ env("API_getDivert", "somedefaultvalue") }}">
        <input type="hidden" id="API_data_ovf_kanban" value="{{ env("API_data_ovf_kanban", "somedefaultvalue") }}">
        <input type="hidden" id="API_redpost" value="{{ env("API_redpost", "somedefaultvalue") }}">
        
        
        <!--<script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_daico_CSV_store.js') . '?' . env('APP_VERSION') }}"></script>--> 

        <script language="JavaScript" src="{{ asset('JS/Hotcall/localStorage.js') . '?' . env('APP_VERSION') }}"></script>        
        <script language="JavaScript" src="{{ asset('JS/Hotcall/hotcall.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_reoccurHC.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_NGparts.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_divert.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_ovf.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_redPost.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_daico_CSV.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_dockCodes.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_modelToyota.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/actionsKanban.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/actionsAddress.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/actionsMros.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/actionsTime.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_loadForUpdate.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('js/menu.js') . '?' . env('APP_VERSION') }}"></script>
        

        <script language="JavaScript" src="{{ asset('JS/Hotcall/hotcallUpdate.js') . '?' . env('APP_VERSION') }}"></script>
        <script language="JavaScript" src="{{ asset('JS/Hotcall/ajax_data.js') . '?' . env('APP_VERSION') }}"></script>
    
        
        @yield('errors') <!-- chyby vypisuji do alertu v index.blade.php -->
    </body>
    
</html> 