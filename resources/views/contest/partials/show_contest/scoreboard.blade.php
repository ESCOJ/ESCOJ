<div class="form-group">
    
     <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">Rank</th>
                <th style="text-align: center;">Contestant</th>
                @foreach($contest->problems()->orderBy('letter_id')->get() as $problem)
                    <th style="text-align: center;">{{ $problem->pivot->letter_id  }}</th>
                @endforeach
                <th style="text-align: center;">Time</th>
                <th style="text-align: center;">AC</th>
            </tr>
        </thead>

        <tbody style="text-align: center;" >
            @foreach($contest->users()->get(['users.id','nickname','avatar']) as $user)
                <tr>
                    <td><span class="label label-success">1</span></td>
                    <td>
                        <img src="{{ asset('images/user_avatar/'. $user->avatar) }}" class="img-circle" style=" width:28px; height:28px; position: relative; left: -10px;"> 
                        <span class="label label-primary">{{ $user->nickname }}</span>
                    </td>

                    @foreach($contest->problems()->orderBy('letter_id')->get() as $problem)
                        <td>{{ count($user->judgments()->where('contest_id',$contest->id)->where('problem_id',$problem->id)->get() )}}</td>
                    @endforeach

                    
                    <td>420</td>

                    <td style="background-color: #99FF99; color: black; line-height: 10px;">
                        <label>
                            {{ count($user->judgments()->where('contest_id',$contest->id)->where('judgment', 'Accepted')->get() )}}
                        </label>
                        <br>
                        <small >
                            (4)
                        </small>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

</div>

