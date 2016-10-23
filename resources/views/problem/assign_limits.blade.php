@extends('layouts.main')

@section('title' , 'Assign Limits')

@section('styles')
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>Assign Limits</center></strong></div>
                    <div class="panel-body">
                        {!!Form::model($problem,['route'=> ['problem.assignLimits',$problem->id],'method'=>'PUT','class' => 'form-horizontal' ])!!}

                            @include('problem.partials.limits')

                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5 row">
                                    {!!Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('type' => 'submit', 'class' => 'form-control btn btn-primary'))!!}
                                   
                                    @if(!is_null($flag_update))
                                        @if(session('addDatasets'))
                                            <br><br>
                                            {!!Html::decode(link_to_route('problem.datasets', $title='<i class="fa fa-plus" aria-hidden="true"></i> Add Datasets',$parameters = ['id' => $problem->id, 'flag_update' => 'update'] , $attributes = ['id'=>'add_datasets', 'class'=>'form-control btn btn-primary']))!!}
                                        @endif 
                                        <br><br>
                                        {!! Html::decode(link_to_route('problem.problems', $title='<i class="fa fa-reply" aria-hidden="true"></i> Go Back',$parameters = [] , $attributes = ['id'=>'add_datasets', 'class'=>'form-control btn btn-primary']))!!}
                                    @elseif(session('addDatasets'))
                                            <br><br>
                                            {!!Html::decode(link_to_route('problem.datasets', $title='<i class="fa fa-plus" aria-hidden="true"></i> Add Datasets',$parameters = [$problem->id] , $attributes = ['id'=>'add_datasets', 'class'=>'form-control btn btn-primary']))!!}
                                    @endif
                                </div>
                            </div>

                        {!!Form::close()!!}

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {!!Html::script('js/problem/assignLimits.js')!!}
    <script>
        $('div.alert').delay(60000).fadeOut(350);
    </script>
@endsection
