@extends('layouts.main')

@section('title' , 'Institutions-admin')

@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Institutions</div>
                    <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h5>
                                    @include('flash::message')
                                </h5>
                            </div>  
                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'institution.index', 'method' => 'GET'])!!}
                        
                                <div class="form-group">
                                    <table style="border-collapse: separate;margin:0 auto;">
                                        <tr style="display:inline; border-spacing:10px;">
                                            <td>
                                                {!! Html::decode(link_to_route('institution.create', $title = '<i class="fa fa-plus" aria-hidden="true"></i> Add institution', $parameters = [], $attributes = [ 'class' => 'btn btn-primary'])) !!} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                            <td>
                                                {!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Title or ID'])!!}
                                            </td>
                                            <td>
                                                {!! Form::select('country',$countries,null,['id'=>'country', 'class' => 'form-control','placeholder'=>'Select a country']) !!}
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-default">
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
                                        <th style="text-align: center;" >Name</th>
                                        <th style="text-align: center;" >Country</th>
                                        <th style="text-align: center;" >Edit</th>
                                        <!--<th style="text-align: center;" >Delete</th>-->

                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    @foreach($institutions as $institution)
                                        <tr>
                                            <!--ID-->
                                            <td>
                                                {{ $institution->id }}
                                            </td>
                                            <!--Name-->
                                            <td>
                                                {{ $institution->name }}
                                            </td>
                                             <!--Country-->
                                            <td>
                                                {{ $institution->country->name }}
                                            </td>
                                            <!--Edit-->
                                            <td>
                                                {!! Html::decode(link_to_route('institution.edit', $title = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', $parameters = ['id' => $institution->id], $attributes = ['class' => 'btn btn-primary', 'title' => 'Edit description, tags, languages and other stuff.'])) !!}
                                            </td>
                                            <!--Delete
                                            <td>
                                                {!!Form::open(['route'=> ['institution.destroy',$institution->id],'method'=>'DELETE'])!!}
                                                    {!!Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit', 'class' => 'btn btn-danger', 'title' => 'Delete institution'))!!}
                                                {!!Form::close()!!}
                                            </td>
                                            -->
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div style="text-align: center;">
                                {{ $institutions->appends(Request::input())->render() }}
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
        $('#country').chosen({
        });
    </script>
    <script type="text/javascript">  
        $('div.alert').delay(10000).fadeOut(350);
    </script>

@endsection
