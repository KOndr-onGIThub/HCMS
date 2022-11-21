@extends('orderSumm/summary_layout')

@section('title', config('app.shortName')  . ' - Order Summary')

@section('content')

<div>
    
    <label for="kanbanOS">zadejte KANBAN a stiskni enter</label><br>
    <input ID="kanbanOS" class="inputWidth_200 inputHeight_80" type="text" name="kanbanOS" placeholder="KBN" autofocus autocomplete="off">

</div>

<div id="myButtonsPosition"></div>

    <div>

        <table id='summaryTable' class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Dock</th>
                    <th>kanban</th>
                    <th>Manifest</th>
                    <th>mros</th>
                    <th>ordered box</th>
                    <th>part number</th>
                    <th>part suffix</th>
                </tr>
            </thead>
                <tbody id="tbody_order_summary_ALL">
                    <!-- see JS -->




                </tbody>
        </table>   
    </div>
   
        
@endsection

