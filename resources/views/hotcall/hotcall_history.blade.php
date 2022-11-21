<div>
    <fieldset>
        <legend><strong><a href="{{ url('History') }}" title="detail Historie" class="a_decor1">HISTORIE</a></strong></legend>
        
            @isset($calls)
            
                {{ $lastPrettyTime = '' }}
                 @for($i=0; $i<=( $howManyHC -1); $i++) <!-- mionus 1 tady musi byt -->
                     @if($prettyTimes[$i] != $lastPrettyTime)
                         </table>
                             <label> {{ $lastPrettyTime = $prettyTimes[$i] }} </label>  <!-- promena se vypise a zaroven zmeni index -->
                         <table border=3 width="230px">
                     @endif
                        <tr>
                            <td> {{ $normalTimes[$i] }} </td>
                            <td> {{ $calls[$i]->kanban }} </td>
                            <td> {{ $calls[$i]->address }} </td>
                        </tr>
                 @endfor
                 
            @endisset

    </fieldset>
</div>