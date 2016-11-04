<div id="problem_table" class="form-group">
    
     <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">TITLE</th>
                <th style="text-align: center;">ACCURACY</th>
                <th style="text-align: center;">SOLVED</th>
                <th style="text-align: center;">SUBMISSIONS</th>
                @if(Auth::check())
                    <th style="text-align: center;">SUBMIT</th>
                @endif
            </tr>
        </thead>

        <tbody style="text-align: center;" >
            @foreach($contest->problems()->orderBy('letter_id')->get() as $problem)
                <tr>
                    <td><span class="label label-primary">{{ $problem->pivot->letter_id }}</span></td>
                    <td>
                    <a onclick = "showProblem({{ $problem->id }})" id="show_problem" style="cursor:pointer;">
                        {{ $problem->name }}
                    </a>
                    </td>
                    <td>0.0 %</td>
                    <td>0</td>
                    <td>0</td>

                    @if(Auth::check())
                        <td>
                            {!! Html::decode(link_to_action('JudgementController@create', $title = '<i class="fa fa-paper-plane" aria-hidden="true"></i>', $parameters = ['problem_id'=> $problem->id ], $attributes = [ ])) !!}
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>

    </table>

</div>

