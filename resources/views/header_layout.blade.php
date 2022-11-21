<span>
    <img id='menu-button' src="{{ asset('pictures/menuButton_64x64.png') . '?' . env('APP_VERSION') }}" alt="menu" title="MENU" class='pointer'>

        <ul id='menu'>

                <li><span> <a href="{{ url('') }}" title="Domů"><img src="{{ asset('pictures/signpost_16x16.png') . '?' . env('APP_VERSION') }}" alt="home" title="Domů">Home</a> </span></li>
            <li><span>-</span></li>

                <li><span> <a href="{{ url('Hotcall') }}" title="Volání"><img src="{{ asset('pictures/call_16x16.png') . '?' . env('APP_VERSION') }}" alt="phone" title="Volání">Volání</a> </span></li>
                <li><span> <a href="{{ url('History') }}"title="Historie"><img src="{{ asset('pictures/history_16x16.png') . '?' . env('APP_VERSION') }}" alt="history" title="Historie">Historie</a> </span></li>
                <li><span> <a href="{{ url('OrderSumm') }}"title="Order Summary"><img src="{{ asset('pictures/summary_16x16.png') . '?' . env('APP_VERSION') }}" alt="order summary" title="Order Summary">Order Summary</a> </span></li>
                <li><span> <a href="{{ url('divert') }}"title="Divert"><img src="{{ asset('pictures/divert_16x16.png') . '?' . env('APP_VERSION') }}" alt="divert" title="Divert">Divert</a> </span></li>

            <li><span>-</span></li>

                <li><span> <a href="{{ url('') }}" title=""><img src="" alt="" title="">Připravuji</a> </span></li>
                <li><span> <a href="{{ url('') }}" title=""><img src="" alt="" title="">Připravuji</a> </span></li>
                
            <li><span>-</span></li>
                @php
                    $menutbl = '<li class="disabled_menu"><span> <a href="" title="NEMÁTE OPRAVNĚNÍ"><img src="' . asset('pictures/tablet_16x16.png') . '?' . env('APP_VERSION') . '" alt="tablet" title="Tablet">Obrazovka Tabletu</a> </span></li>';

                    if(is_array(Auth::user()->getARoles())){

                        $role_1="admin";
                        $role_2="log_kbr";
                        $role_3="log_leaders";
                                // jelikoz zobrazeni stranky je jiz podmineno spadat do nejaké kategorie, tak zde uz neresim situaci kdy role je null
                            if(in_array($role_1, Auth::user()->getARoles()) || in_array($role_2, Auth::user()->getARoles()) || in_array($role_3, Auth::user()->getARoles()) ) {
                                $menutbl = '<li><span> <a href="' . url('TabletScreen') . '" title="Obrazovka tabletu"><img src="' . asset('pictures/tablet_16x16.png') . '?' . env('APP_VERSION') . '" alt="tablet" title="Tablet">Obrazovka Tabletu</a> </span></li>';
                            }
                    }
                
                @endphp
                {!! $menutbl !!}
     
        </ul>
</span>
@php 
    $TESTorDEV_bckgColor =  env('APP_ENV') == 'production' ? 'PROD' : 'TESTorDEV'; //<!--rozhodnu jakou tridu pridam dle prostredi-->

    echo('<span class="user_name ' . $TESTorDEV_bckgColor . '">|| ENV.= ' . strtoupper(env('APP_ENV')) . ' || USER= ');
        if(is_array(Auth::user()->getARoles())){
            echo(Auth::user()->getWholeName() . ' || ROLES= ');
            $roleList ='';
            $i=0;
            foreach( Auth::user()->getARoles() as $roleList ){
                echo(($i>0) ? ' + ' : '');
                echo($roleList  );
                $i++;
            }
          
         }else{
            echo('unknown user');
         }
    echo(' ||</span>');
@endphp