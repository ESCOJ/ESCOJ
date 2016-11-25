<table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">User</th>
                <th style="text-align: center;">Problem</th>
                <th style="text-align: center;">Judgement</th>
                <th style="text-align: center;">Time<small> (ms)</small></th>
                <th style="text-align: center;">Mem<small> (kb)</small></th>
                <th style="text-align: center;">Size<small> (b)</small></th>
                <th style="text-align: center;">Lang</th>

            </tr>
        </thead>

        <tbody style="text-align: center;" >
            @foreach($judgments as $judgment)
                <tr>
                    <td>{{ $judgment->id }}</td>
                    <td>{{ $judgment->submitted_at }}</td>
                    <td>{{ $judgment->user->nickname }}</td>
                    <td>{{ $judgment->problem_id }}</td>
                    @if($judgment->judgment != 'Accepted')
                        <td>
                            <span class="label label-danger">
                                <strong>{{ $judgment->judgment }}</strong>
                            </span>
                        </td>
                    @else
                        <td>
                            <span class="label label-success">
                                <strong>{{ $judgment->judgment }}</strong>
                            </span>
                        </td>
                    @endif
                    <td>{{ $judgment->time }}</td>
                    <td>{{ $judgment->memory }}</td>
                    <td>{{ $judgment->file_size }}</td>
                    <td>{{ $judgment->language }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div style="text-align: center;">
        {{ $judgments->appends(Request::input())->render() }}
    </div>