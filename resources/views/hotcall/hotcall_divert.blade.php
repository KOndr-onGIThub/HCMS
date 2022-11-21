        <div >
            <fieldset>
                <legend>
                    <strong>
                        <a href="{{ url('/divert') }}" title="detail Divert" class="a_decor1">DIVERT - </a>
                            <span id='divert_id' hidden='hidden'></span>
                            <span id='divert_supplier'></span> / 
                            <span id='divert_part'></span>
                    </strong>
                </legend>
                    
                <table>
                    <tr>
                        <td> <label for="divert_implementatio_by">KDO: </label> </td>
                        <td> <input id="divert_implementatio_by" name="divert_implementatio_by" class="inputWidth_150 inputHeight_25" readonly> </td>
                        <td rowspan="2"> <label for="divert_problem_description">CO: </label> </td>
                        <td rowspan="2"> <input id="divert_problem_description" name="divert_problem_description" class="inputWidth_340 inputHeight_70b" readonly> </td>
                    </tr>
                    <tr>
                        <td> <label for="divert_instead_of_control">KDE: </label> </td>
                        <td> <input id="divert_instead_of_control" name="divert_instead_of_control"  class="inputWidth_150 inputHeight_25" readonly> </td>
                    </tr>
                        
                        
                </table>
            </fieldset>
        </div>