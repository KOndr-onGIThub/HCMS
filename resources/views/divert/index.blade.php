@extends('divert/divert_layout')

@section('title', config('app.shortName')  . ' - Divert')

@section('content')



<div id="myDivertButtonsPosition"></div>

    <div>

        <table id='divertTable' class="display" style="width:80%">
            <thead>
                <tr>
                    <th>KANBAN</th>
                    <th>DODAVATEL</th>
                    <th>DOCK</th>
                    <th>POSLEDNÍ ÚPRAVA</th>

                </tr>
            </thead>
                <tbody id="tbody_divert_ALL"> 
                    <!-- see JS -->




                </tbody>
        </table>   
    </div>
   
        
@endsection

