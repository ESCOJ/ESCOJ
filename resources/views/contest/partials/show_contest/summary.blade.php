
<fieldset>
    <legend><h4 class="text-primary">Description</h4></legend>
    {!! $contest->description !!}
</fieldset>
<br>
<table class="table table-condensed table-bordered table-responsive">
    <tbody >
        
        <tr>
            <td>
                <h4 class="text-primary">Organized By:</h4>
            </td>
            <td>
                {!! $contest->organization->name !!}
            </td>
        </tr>

        <tr>
            <td>
                <h4 class="text-primary">Start date:</h4>
            </td>
            <td>
                {!! $contest->start_date !!}
            </td>
        </tr>

        <tr>
            <td>
                <h4 class="text-primary">End_date:</h4>
            </td>
            <td>
                {!! $contest->end_date !!}
            </td>
        </tr>

        <tr>
            <td>
                <h4 class="text-primary">Penalization:</h4>
            </td>
            <td>
                {!! $contest->penalization !!}
            </td>
        </tr>

        <tr>
            <td>
                <h4 class="text-primary">Frozen time:</h4>
            </td>
            <td>
                {!! $contest->frozen_time !!}
            </td>
        </tr> 

        <tr>
            <td>
                <h4 class="text-primary">Access:</h4>
            </td>
            <td>
                {!! title_case($contest->access_type) !!}
            </td>
        </tr>

        <tr>
            <td>
                <h4 class="text-primary">Offcontest:</h4>
            </td>
            <td>
                @if($contest->offcontest == 1)
                    YES
                @else
                    NO
                @endif
            </td>
        </tr>

        @if($contest->offcontest == '1')
            <tr>
                <td>
                    <h4 class="text-primary">Offcontest penalization:</h4>
                </td>
                <td>
                    {!! $contest->offcontest_penalization !!}
                </td>
            </tr>
            
            <tr>
                <td>
                    <h4 class="text-primary">Offcontest start date:</h4>
                </td>
                <td>
                    {!! $contest->offcontest_start_date !!}
                </td>
            </tr>

            <tr>
                <td>
                    <h4 class="text-primary">Offcontest end date:</h4>
                </td>
                <td>
                    {!! $contest->offcontest_end_date !!}
                </td>
            </tr>
       @endif

    </tbody>
</table>
