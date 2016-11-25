@extends('layouts.main')

@section('title' , 'Organizations-admin')

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Organizations</div>
                    <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h5>
                                    @include('flash::message')
                                </h5>
                            </div>  
                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'organization.index', 'method' => 'GET'])!!}
                        
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5">
                                        {!! Html::decode(link_to_route('organization.create', $title = '<i class="fa fa-plus" aria-hidden="true"></i> Add organization', $parameters = [], $attributes = [ 'class' => 'btn btn-primary'])) !!}
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
                                        <th style="text-align: center;" >Name</th>
                                        <th style="text-align: center;" >Edit</th>
                                        <!--<th style="text-align: center;" >Delete</th>-->

                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    @foreach($organizations as $organization)
                                        <tr>
                                            <!--ID-->
                                            <td>
                                                {{ $organization->id }}
                                            </td>
                                            <!--Name-->
                                            <td>
                                                {{ $organization->name }}
                                            </td>
                                            <!--Edit-->
                                            <td>
                                                {!! Html::decode(link_to_route('organization.edit', $title = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', $parameters = ['id' => $organization->id], $attributes = ['class' => 'btn btn-primary', 'title' => 'Edit description, tags, languages and other stuff.'])) !!}
                                            </td>
                                            <!--Delete
                                            <td>
                                                {!!Form::open(['route'=> ['organization.destroy',$organization->id],'method'=>'DELETE'])!!}
                                                    {!!Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('type' => 'submit', 'class' => 'btn btn-danger', 'title' => 'Delete organization'))!!}
                                                {!!Form::close()!!}
                                            </td>
                                            -->
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div style="text-align: center;">
                                {{ $organizations->appends(Request::input())->render() }}
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