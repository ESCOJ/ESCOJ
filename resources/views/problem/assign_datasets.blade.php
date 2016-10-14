@extends('layouts.main')

@section('title' , 'Assign Datasets')

@section('styles')
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>Assign Datasets</center></strong></div>
                    <div class="panel-body">
                        {!!Form::model($problem,['route'=> ['problem.assignDatasets',$problem->id],'method'=>'PUT','class' => 'form-horizontal','files' => true])!!}

                            @include('problem.partials.datasets')

                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5 row">
                                    {!!Form::submit('Save',['class'=>'form-control btn btn-primary'])!!}
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
    {!!Html::script('plugins/fileinput/js/plugins/canvas-to-blob.min.js')!!}
    {!!Html::script('plugins/fileinput/js/plugins/sortable.min.js')!!}
    {!!Html::script('plugins/fileinput/js/plugins/purify.min.js')!!}
    {!!Html::script('plugins/fileinput/js/fileinput.js')!!}
    {!!Html::script('js/problem/assignLimits.js')!!}

    <script type="text/javascript">
        $("#dataset").fileinput({
            maxFileSize : 5000,
            removeClass : "btn btn-default",
            removeLabel : "Delete",
            previewFileType : "text",
            msgProgress : 'Loading {percent}%',
            previewClass : 'file_preview',
            browseClass : "btn btn-primary",
            browseLabel : "Upload file",
            browseIcon : '<i class="fa fa-file"></i>&nbsp;',
            removeIcon : '<i class="fa fa-trash"></i>',
            showUpload: false,
            showZoom: false,
            showDrag: false,
            showUploadedThumbs: false,
            allowedFileExtensions: ["zip"],
            msgValidationError: "File upload error",
            msgSizeTooLarge: 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!',
        });
    </script>

    <script>
        $('div.alert').delay(600000).fadeOut(350);
    </script>
@endsection
