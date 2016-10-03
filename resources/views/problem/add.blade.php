@extends('layouts.main')

@section('title' , 'Add problem')

@section('styles')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>Add Problem</center></strong></div>
                    <div class="panel-body">
                        {!!Form::open(['route'=>'problem.store', 'method'=>'POST','files' => true,'class' => 'form-horizontal'])!!}
                            @include('problem.partials.problem')
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {!!Form::submit('Add',['class'=>'btn btn-primary'])!!}
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
    {!!Html::script('plugins/fileinput/js/plugins/canvas-to-blob.min.js')!!}
    {!!Html::script('plugins/fileinput/js/plugins/sortable.min.js')!!}
    {!!Html::script('plugins/fileinput/js/plugins/purify.min.js')!!}
    <script type="text/javascript">
        $('.textarea-content').trumbowyg();
    </script>
@endsection
