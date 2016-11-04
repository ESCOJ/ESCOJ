
<div class="form-group">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
    {!!Form::open(['route' => 'judgment.index', 'method' => 'POST'])!!}
    <div id = "search" class="form-group">
        <table style="border-collapse: separate;margin:0 auto;">
            <tr style="display:inline; border-spacing:10px;">
                <td>
                    {!!Form::text('user',null,['id'=>'user','class'=>'form-control ','placeholder'=>'User ID'])!!}
                </td>
                <td>
                   {!!Form::text('problem',null,['id'=>'problem','class'=>'form-control ','placeholder'=>'Problem ID'])!!}
                </td>
                
                <td>
                    {!! Form::select('languages',$languages,null,['id'=>'language', 'class' => 'form-control select-chosen','placeholder'=>'Select a language']) !!}
                </td>
                <td>
                    <button type="button" class="btn btn-primary" >
                        <i class="fa fa-search" aria-hidden="true"></i> Filter
                    </button>
                </td>
            </tr>

        </table>
    </div>
    {!! Form::close() !!}

     <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">User</th>
                <th style="text-align: center;">Problem</th>
                <th style="text-align: center;">Judgement</th>
                <th style="text-align: center;">Time</th>
                <th style="text-align: center;">Mem</th>
                <th style="text-align: center;">Size</th>
                <th style="text-align: center;">Lang</th>

            </tr>
        </thead>

        <tbody style="text-align: center;" >
            @foreach($judgments as $judgment)
                <tr>
                    <td>{{ $judgment->id }}</td>
                    <td>{{ $judgment->submitted_at }}</td>
                    <td>{{ $judgment->user_id }}</td>
                    <td>{!!link_to_route('problem.show', $title = $judgment->problem_id, $parameters = ['id'=> $judgment->problem_id ], $attributes = [ ]) !!}</td>
                    @if($judgment->judgment != 'Accepted')
                        <td style="color:#FF0000;"><strong>{{ $judgment->judgment }}</strong></td>
                    @else
                        <td style="color:#3ADF00;"><strong>{{ $judgment->judgment }}</strong></td>
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
    
</div>

