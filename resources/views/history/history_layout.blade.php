<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--LINKS-->
            <link rel="shortcut icon" href="{{ asset('pictures/history_32x32.png') . '?' . env('APP_VERSION') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') . '?' . env('APP_VERSION') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui-1.12.1/jquery-ui.min.css') . '?' . env('APP_VERSION') }}">
        <!--DataTables-->
            <!--<link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/datatables.min.css') }}">-->
            <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/jquery.dataTables.min.css') . '?' . env('APP_VERSION') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/buttons.dataTables.min.css') . '?' . env('APP_VERSION') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/fixedHeader.dataTables.min.css') . '?' . env('APP_VERSION') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/scroller.dataTables.min.css') . '?' . env('APP_VERSION') }}">
            


    <!--SCRIPTS-->
            <script src="{{ asset('js/Library/jquery-3.4.1.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js'. '?' . env('APP_VERSION') ) }}"></script>
        <!--DataTables-->
            <script src="{{ asset('DataTables/JS/jquery.dataTables.min.js') . '?' . env('APP_VERSION') }}"></script>  
            <script src="{{ asset('DataTables/JS/dataTables.buttons.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/jszip.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/buttons.colVis.min.js') . '?' . env('APP_VERSION') }}"></script> <!--zatim nevyuzivam-->
            <script src="{{ asset('DataTables/JS/buttons.flash.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/buttons.html5.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/buttons.print.min.js') . '?' . env('APP_VERSION') }}"></script>
            <!--<script src="{{ asset('DataTables/JS/dataTables.fixedHeader.min.js') . '?' . env('APP_VERSION') }}"></script>  neni fukcni soucasne se skrolovanim-->
            <script src="{{ asset('DataTables/JS/dataTables.fixedColumns.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/dataTables.scroller.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/pdfmake.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/vfs_fonts.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/dataTables.colReorder.min.js') . '?' . env('APP_VERSION') }}"></script>
            <script src="{{ asset('DataTables/JS/datatables.min.js') . '?' . env('APP_VERSION') }}"></script>
        
        
        <title>@yield('title', 'HCMS')</title>
        
    </head>
    
    <body>
        
        <header>
            <div>
                @include('header_layout')
            </div>
            
            
            <h1 title="Zobrazuje historii hotcalu v databazi.">{{ config('app.name') }} - HISTORIE</h1>
            
            
        </header>
        

         @yield('content')
         
     

        <input type="hidden" id="getHistoryURL" value="{{ url('History') }}">
       
       
        <script src="{{ asset('js/History/historyTable.js') . '?' . env('APP_VERSION') }}"></script>
        <script src="{{ asset('js/menu.js') . '?' . env('APP_VERSION') }}"></script>
    </body>
    
</html>