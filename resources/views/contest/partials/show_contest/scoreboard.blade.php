<div class="form-group">
    
     <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">Rank</th>
                <th style="text-align: center;">Contestant</th>
                @foreach($problems as $problem)
                    <th style="text-align: center;">{{ $problem }}</th>
                @endforeach
                <th style="text-align: center;">Time</th>
                <th style="text-align: center;">AC</th>
            </tr>
        </thead>

        <tbody style="text-align: center;" >
            <?php $pos = 1; ?>
            @foreach($users as $user)
                <tr>
                    <!--Rank-->
                    @if( ($loop->index > 0)  and ( ($users[$loop->index]['AC'] == $users[$loop->index-1]['AC']) and ($users[$loop->index]['time'] == $users[$loop->index-1]['time']) ) )
                        <td><span class="label label-info">{{ $pos }}</span></td>
                    @else
                        <?php $pos = $loop->iteration; ?>
                        <td><span class="label label-info">{{ $pos }}</span></td>
                    @endif

                    <!--Avatar and Nickname-->
                    <td>
                        <img src="{{ asset('images/user_avatar/'. $user['avatar']) }}" class="img-circle" style=" width:28px; height:28px; position: relative; left: -10px;"> 
                        <span class="label label-primary">{{ $user['nickname']}}</span>
                    </td>
                    
                    <!--Problems-->
                    @foreach($user['problems'] as $problem)
                        @if($problem['status'] === 'accepted')
                            <td style="background-color: #92FFB1; line-height: 10px;">
                                @if($problem['attempts'] > 0)
                                    <label>
                                        {{ $problem['min'] }}
                                    </label>
                                    <br>
                                    <small >
                                        ({{ $problem['attempts'] }})
                                    </small>
                                @else
                                     <br>
                                    <label>
                                        {{ $problem['min'] }}
                                    </label>
                                @endif
                            </td>
                        @elseif($problem['status'] === 'attempted')
                            <td style="background-color: #FFADAD; line-height: 10px;">
                                <br>
                                <label>
                                    ({{ $problem['attempts'] }})
                                </label>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach

                    <!--Time-->
                    <td>{{ $user['time'] }}</td>

                    <!--AC-->
                    <td style="background-color: #92FFB1; line-height: 10px;">
                        <br>
                        <label>
                            {{ $user['AC'] }}
                        </label>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

</div>

