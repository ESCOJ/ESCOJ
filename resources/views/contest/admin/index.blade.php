@extends('layouts.main')

@section('title' , 'Contests-admin')

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Your Contests</div>
                    <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h5>
                                    @include('flash::message')
                                </h5>
                            </div>  
                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'contest.contests', 'method' => 'GET'])!!}
                        
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5">
                                        {!! Html::decode(link_to_route('contest.create', $title = '<i class="fa fa-plus" aria-hidden="true"></i> Add contest', $parameters = [], $attributes = [ 'class' => 'btn btn-primary'])) !!}
                                        </div>
                                        <div class="col-md-3">
                                            {!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Title or ID'])!!}
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa fa-search" aria-hidden="true"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div><br>
                        
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
                                        <th style="text-align: center;" >Edit</th>
                                        <th style="text-align: center;" >Delete</th>
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
                                                {!!link_to_route('problem.show', $title = $contest->name, $parameters = ['id'=> $contest->id ], $attributes = [ ]) !!}
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
                                                    <span class="label label-default"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                @else
                                                    <span class="label label-primary"><i class="fa fa-unlock" aria-hidden="true"></i><span>
                                                @endif
                                            </td>
                                            <!--Edit-->
                                            <td>
                                                {!! Html::decode(link_to_route('contest.edit', $title = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', $parameters = ['id' => $contest->id], $attributes = ['class' => 'btn btn-primary', 'title' => 'Edit description, problems, dates, etc.'])) !!}
                                            </td>
                                            <!--Delete-->
                                            <td>
                                                {!!Form::open(['route'=> ['contest.destroy',$contest->id],'method'=>'DELETE'])!!}
                                                    {!!Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit', 'class' => 'btn btn-danger', 'title' => 'Delete contest'))!!}
                                                {!!Form::close()!!}
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
    <script type="text/javascript">  
        $('div.alert').delay(10000).fadeOut(350);
    </script>
@endsection