@extends('layouts.main')

@section('title' , 'Add problem')

@section('styles')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
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
                        {!!Form::open(['class' => 'form-horizontal'])!!}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                            @include('problem.partials.problem')

                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5">
                                    {{-- {!!link_to('#', $title='Save', $attributes = ['id'=>'register_problem_description', 'class'=>'form-control btn btn-primary',' onclick' => 'createProblemDescription()'], $secure = null)!!}--}}
                                    <button onclick = "createProblemDescription()" id="register_problem_description" class="form-control btn btn-primary" type="button">Save</button>

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
    {!!Html::script('plugins/fileinput/js/fileinput.js')!!}
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    {!!Html::script('js/problem/addProblem.js')!!}
    
    <script type="text/javascript">
        $('.textarea-content').trumbowyg();
        $("#dataset").fileinput({
            maxFileSize : 5000,
            msgProgress : 'Loading {percent}%',
            previewClass : 'file_preview',
            previewFileType : "text",
            browseClass : "btn btn-primary",
            browseLabel : "Upload file",
            browseIcon : '<i class="fa fa-file"></i>&nbsp;',
            removeClass : "btn btn-default",
            removeLabel : "Delete",
            removeIcon : '<i class="fa fa-trash"></i>',
            showUpload: false,
            showZoom: false,
            showDrag: false,
            showUploadedThumbs: false,

            allowedFileTypes : [ 'text', 'object' ],
            msgValidationError: "File upload error",
            msgSizeTooLarge: 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!',
        });
        $('.select-source').chosen({
            
        });
        $('.select-tag').chosen({
            include_group_label_in_selected : true,
        });
    </script>
@endsection
