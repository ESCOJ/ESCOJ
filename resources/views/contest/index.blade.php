@extends('layouts.main')

@section('title' , 'Contests')

@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Contests</div>
                    <div class="panel-body">

                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'contest.index', 'method' => 'GET'])!!}
                                <div id = "search" class="form-group">
                                    <table style="border-collapse: separate;margin:0 auto;">
                                        <tr style="display:inline; border-spacing:10px;">
                                            <td>
                                                {!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Title or ID'])!!}
                                            </td>
                                            <td>
                                                {!! Form::select('organization',$organizations,null,['id'=>'organization', 'class' => 'form-control select-chosen','placeholder'=>'All organizations']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('time',$times,null,['id'=>'time', 'class' => 'form-control select-chosen','placeholder'=>'All times']) !!}
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa fa-search" aria-hidden="true"></i> Search
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
                                        <th style="text-align: center;" >Title</th>
                                        <th style="text-align: center;" >Start</th>
                                        <th style="text-align: center;" >End</th>
                                        <th style="text-align: center;" >Offcontest</th>
                                        <th style="text-align: center;" >Access</th>
                                        <th style="text-align: center;" >Organization</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    @foreach($contests as $contest)
                                        <tr>
                                            <!--ID-->
                                            <td>
                                                {{ $contest->id }}
                                            </td>
                                            <!--Title-->
                                            <td>
                                                {!!link_to_route('contest.show', $title = $contest->name, $parameters = ['id'=> $contest->id ], $attributes = [ ]) !!}
                                            </td>
                                            <!--Start-->
                                            <td>
                                                {{ $contest->start_date }}
                                            </td>
                                            <!--End-->
                                            <td>
                                                {{ $contest->end_date }}
                                            </td>
                                            <!--Offcontest-->
                                            <td>
                                                @if($contest->offcontest == '1')
                                                    <span class="label label-primary">YES</span>
                                                @else
                                                    <span class="label label-default">NO</span>
                                                @endif
                                            </td>
                                            <!--Access-->
                                            <td>
                                                @if($contest->access_type == 'private')
                                                    <span class="label label-primary">
                                                        PRIVATE
                                                    </span>
                                                @else
                                                    <span class="label label-default">
                                                        PUBLIC
                                                    <span>
                                                @endif
                                            </td>
                                            <!--Organization-->
                                            <td>
                                                <span class="label label-info">
                                                        {{ $contest->organization->name }}
                                                </span>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div style="text-align: center;">
                                {{ $contests->appends(Request::input())->render() }}
                            </div>

                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')    
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    
    <script type="text/javascript">  
        $('.select-chosen').chosen({
        });
    </script>
@endsection