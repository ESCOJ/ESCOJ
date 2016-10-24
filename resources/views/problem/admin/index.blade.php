@extends('layouts.main')

@section('title' , 'Add Submit')

@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Your Problems</div>
                    <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h5>
                                    @include('flash::message')
                                </h5>
                            </div>  
                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'problem.problems', 'method' => 'GET'])!!}
                        
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5">
                                        {!! Html::decode(link_to_route('problem.create', $title = '<i class="fa fa-plus" aria-hidden="true"></i> Add problem', $parameters = [], $attributes = [ 'class' => 'btn btn-primary'])) !!}
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
                                        <th style="text-align: center;" >Problem statement</th>
                                        <th style="text-align: center;" >Limits</th>
                                        <th style="text-align: center;" >Datasets</th>
                                        <th style="text-align: center;" >DELETE</th>

                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    @foreach($problems as $problem)
                                        <tr>
                                            <!--ID-->
                                            <td>
                                                {{ $problem->id }}
                                            </td>
                                            <!--Title-->
                                            <td>
                                                {!!link_to_route('problem.show', $title = $problem->name, $parameters = ['id'=> $problem->id ], $attributes = [ ]) !!}
                                            </td>
                                            <!--Edit Problem Statement-->
                                            <td>
                                                {!! Html::decode(link_to_route('problem.edit', $title = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', $parameters = ['id' => $problem->id], $attributes = ['class' => 'btn btn-primary', 'title' => 'Edit description, tags, languages and other stuff.'])) !!}
                                            </td>
                                            <!--Edit Limits-->
                                            <td>
                                                {!! Html::decode(link_to_route('problem.limits', $title = '<i class="fa fa-archive" aria-hidden="true"></i>', $parameters = ['id' => $problem->id, 'flag_update' => 'update'], $attributes = ['class' => 'btn btn-info', 'title' => 'Edit limits of problem (Memory, Source Lenght, Time Per Case, Total Time.)' ])) !!}
                                            </td>
                                            <!--Edit Datasets-->
                                            <td>
                                                {!! Html::decode(link_to_route('problem.datasets', $title = '<i class="fa fa-database" aria-hidden="true"></i>', $parameters = ['id' => $problem->id, 'flag_update' => 'update'], $attributes = ['class' => 'btn btn-default', 'title' => 'Edit problem dataset.' ])) !!}
                                            </td>
                                            <!--Delete-->
                                            <td>
                                                {!!Form::open(['route'=> ['problem.destroy',$problem->id],'method'=>'DELETE'])!!}
                                                    {!!Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit', 'class' => 'btn btn-danger', 'title' => 'Delete problem'))!!}
                                                {!!Form::close()!!}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div style="text-align: center;">
                                {{ $problems->appends(Request::input())->render() }}
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
        $('div.alert').delay(10000).fadeOut(350);
    </script>
@endsection