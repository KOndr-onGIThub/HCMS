<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Ondrej Kriska">
        <meta name="description" content="Hot Call solution.">
        <meta name="keywords" content="HC, hot call, hot call managemen system">
        
        <link rel="shortcut icon" href="{{ asset('pictures/call_32x32.png') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui-1.12.1/jquery-ui.min.css') }}">
        
        
        <script src="{{ asset('js/Library/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
        
        

        <title>{{config('app.shortName')}} - Home</title>


    </head>
    <body>
        @include('header_layout')
        
                    <h1 class="title">{{ config('app.name') }} - Home</h1>
                    
                    
                    
                        <h2>Ahoj {{ Auth::user() ? Auth::user()->getName() : 'unknown user' }} vítáme tě v {{ config('app.name') }}</h2>
                        
                        <p>
                            Pro navigaci na další stránky použijte tlačítko <img id='menu-button_example' src="{{ asset('pictures/menuButton_32x32.png') . '?' . env('APP_VERSION') }}" alt="menu" title="takto vypadá tlačítko MENU"> výše.
                        </p>
  
                        <p>
                            <b>Co byste zde rádi viděli?</b><br>
                            a) Grafy top HC<br>
                            b) Stavy andonů<br>
                            c) ... <br>
                            d) ... <br>
                            e) ... <br>
                        </p>
                        
                        <p >&#128526;</p>
                            
                        
                        
                            Podělte se o své návrhy na:
                            <table>
                                <tr>
                                    <td>email: </td>
                                    <td><a style="color:grey ; background:white" href="mailto:ondrej.kriska@toyotacz.com">ondrej.kriska@toyotacz.com</a></td>
                                </tr>
                                <tr>
                                    <td>nebo: </td>
                                    <td><a style="color:grey ; background:white" href="https://teams.microsoft.com/l/team/19%3acb2bf3d91f734751a14894f2594ee72a%40thread.tacv2/conversations?groupId=7a6b2880-0c7b-4d83-91f4-5626bdd55de1&tenantId=52b742d1-3dc2-47ac-bf03-609c83d9df9f" target="_blank"> 
                                                Teams skupina HCMS</a></td>
                                </tr>
                            </table>
                            <p style="color: white">
                                V PŘÍPADĚ POTÍŽÍ S OPRAVNĚNÍM SE OBRAŤTE NA ADMINA<br>
                                CONTACT THE ADMIN IF AUTHORISATION PROBLEM OCCURS<br>
                            </p>


        <script src="{{ asset('js/menu.js') . '?' . env('APP_VERSION') }}"></script>
        
        <?php
        
//        
//        $matice = array(
//            array(1, 3),
//            array(1, 3),
//            array(1, 5),
//            array(4, 6),            
//            array(7, 9),
//        );
//        $unikatni = array_unique($matice);
//            dd( $unikatni);
            
        ?>
        
        
    </body>
</html>

