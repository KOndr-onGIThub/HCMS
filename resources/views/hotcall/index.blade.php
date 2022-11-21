@extends('hotcall/hotcall_layout')

@section('title',  config('app.shortName')  . ' - Volání')

@section('errors')

<!--        vypsat případné chyby ve vyplnění formuláře-->
        @if ($errors->any())
            <div class="NG_valid_list">
<!--                <ul>
                         Vypsat to co neproslo validaci do seznamu <li> / nahradit alertem? 
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach 
                </ul>-->

                        <!-- Vypsat to co neproslo validaci do alertu -->
                        @php
                            $writeErrors = implode("\\n", $errors->all() );
                            echo('<script>alert("' . $writeErrors) . '")</script>';
                        @endphp
            </div>
            
        @endif
        

@endsection

