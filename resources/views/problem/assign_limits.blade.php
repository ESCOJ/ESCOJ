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
                                    {!!Form::submit('Save',['class'=>'form-control btn btn-primary'])!!}
                                    @if(session('addDatasets'))
                                        <br><br>
                                        {!!link_to_route('problem.datasets', $title='Add Datasets',$parameters = [$problem->id] , $attributes = ['id'=>'add_datasets', 'class'=>'form-control btn btn-primary'])!!}
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
        $('div.alert').delay(600000).fadeOut(350);
    </script>
@endsection
