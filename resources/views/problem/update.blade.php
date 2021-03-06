@extends('layouts.main')

@section('title' , 'Update problem')

@section('styles')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
    {!!Html::style('plugins/chosen/chosen.css')!!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>Add Problem</center></strong></div>
                    <div class="panel-body">
                        {!!Form::model($problem,['route'=> ['problem.update',$problem->id],'method'=>'PUT','class' => 'form-horizontal'])!!}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                            @include('problem.partials.problem')

                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5">
                                    <button onclick = "createProblemDescription()" id="register_problem_description" class="form-control btn btn-primary" type="button">
                                        <span class="glyphicon glyphicon-save"></span> Save
                                    </button><br><br>
                                </div>
                                <div class="col-md-2 col-md-offset-5 row">
                                     {!! Html::decode(link_to_route('problem.problems', $title='<i class="fa fa-reply" aria-hidden="true"></i> Go Back',$parameters = [] , $attributes = ['id'=>'add_datasets', 'class'=>'form-control btn btn-primary']))!!}
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
    {!!Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    {!!Html::script('js/problem/addProblem.js')!!}
    
    <script type="text/javascript">
        $('.textarea-content').trumbowyg();
      
        $('.select-source').chosen({
        });

        $('.select-tag').chosen({
            include_group_label_in_selected : true,
        });
    </script>
@endsection
