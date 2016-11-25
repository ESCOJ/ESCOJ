<div id="problem_table" class="form-group">
    
     <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">TITLE</th>
                <th style="text-align: center;">ACCURACY</th>
                <th style="text-align: center;">SOLVED</th>
                <th style="text-align: center;">SUBMISSIONS</th>
                @can('belongs', $contest)
                    @if($contest_type == 'current')
                        <th style="text-align: center;">SUBMIT</th>
                    @endif
                @endcan
            </tr>
        </thead>

        <tbody style="text-align: center;" >
            @foreach($contest->problems()->orderBy('letter_id')->get() as $problem)
                <tr>
                    <td><span class="label label-primary">{{ $problem->pivot->letter_id }}</span></td>
                    <td>
                    <a onclick = "showProblem({{ $problem->id }},  {{ $contest->id }})" id="show_problem" style="cursor:pointer;">
                        {{ $problem->name }}
                    </a>
                    </td>
                    <td>0.0 %</td>
                    <td>0</td>
                    <td>0</td>

                    @can('belongs', $contest)
                        @if($contest_type == 'current')
                            <td>
                                <a onclick = "addJudgment({{ $problem->id }})" id="show_problem" style="cursor:pointer;">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </a>
                            </td>
                        @endif
                    @endcan

                </tr>
            @endforeach
        </tbody>

    </table>

</div>

