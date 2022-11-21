        <div id='' >
            <fieldset>
                <legend>
                    <span id="spanOSpref"> 
                    <strong><a href="{{ url('OrderSumm') }}" title="detail Order Summary" class="a_decor1">ORDER SUMMARY</a></strong> 
                        <span title='PODLE TOHOTA DATA SE HLEDAJI ORDER DATA'> 
                            <input ID="OrdSumm_year" class="inputWidth_70 inputHeight_25" type="number" name="" placeholder="RRRR" value="" autocomplete="off" >
                            <input ID="OrdSumm_month" class="inputWidth_40 inputHeight_25" type="number" name="" placeholder="MM" value="" autocomplete="off" >
                            <input ID="OrdSumm_day" class="inputWidth_40 inputHeight_25" type="number" name="" placeholder="DD" value="" autocomplete="off" >

                            <input id="OSpref" class="saved" type="checkbox" name="OSpref" value=""> <span>Vlastní</span>
                        </span>
                   </span>
                </legend>
                    <table id='order_summary' border="1" width="570" height="100px">

                        <tbody id="tbody_order_summary">
                            <!-- see JS -->
                            


                            
                        </tbody>
                    </table>
            </fieldset>
        </div>