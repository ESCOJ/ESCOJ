
<div class="form-group">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
        <div id = "search" class="form-group">
            <table style="border-collapse: separate;margin:0 auto;">
                <tr style="display:inline; border-spacing:10px;">
                    <td>
                        {!!Form::text('user',null,['id'=>'user','class'=>'form-control ','placeholder'=>'Nickname'])!!}
                    </td>
                    <td>
                       {!!Form::text('problemm',null,['id'=>'problemm','class'=>'form-control ','placeholder'=>'Problem ID'])!!}
                    </td>
                    
                    <td>
                        {!! Form::select('language',$languages,null,['id'=>'language', 'class' => 'form-control select-chosen','placeholder'=>'All languages']) !!}
                    </td>
                    <td>
                        <button onclick="showJudgmentsFiltered()" class="btn btn-primary" >
                            <i class="fa fa-search" aria-hidden="true"></i> Filter
                        </button>
                    </td>
                </tr>

            </table>
        </div>
    <div class="judgments">
        @include('contest.partials.show_contest.judgments_table')
    </div>
    
</div>

