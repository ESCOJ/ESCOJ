@extends('layouts.main')

@section('title' , 'Add Submit')

@section('styles')
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
    <style type="text/css" media="screen">
    
        #editor {
            position: relative;
            width: 800px;
            height: 400px;
            left:70px;
        }
    </style>
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Submit</div>
                    <div class="panel-body">
                        {!!Form::open(['route'=>'judgment.store', 'id' => 'form_judgment','method'=>'POST','files' => true,'class' => 'form-horizontal'])!!}
                            @include('judgment.partials.judgment')
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-5">
                                    <input type="button" value="Clear" onclick="clearBox()" class="btn btn-primary">
                                     
                                    <input type="button" value="Submit" onclick="submitAndCopyTheCode()" class="btn btn-primary">  
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
    {!!Html::script('plugins/ace/src-noconflict/ace.js') !!}
    {!!Html::script('plugins/fileinput/js/fileinput.min.js')!!}

    <script type="text/javascript">
        $("#code").fileinput({
            maxFileSize : 100,
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
            allowedFileTypes : [ 'text', 'object' ],
            msgValidationError: "File upload error",
            msgSizeTooLarge: 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!',
            previewSettings:  {
                text: {width: "460px", height: "160px"},
                object: {width: "460px", height: "160px"}
            }
        });

        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/tomorrow_night_bright");
        editor.session.setMode("ace/mode/c_cpp");

        function clearBox()
        {
            var editor = ace.edit("editor");
            //To get the code from the editor
            //var code = editor.getValue();
        }

        $("#language").change(event => {
            if(event.target.value == 4)
                editor.session.setMode("ace/mode/python");
            else if(event.target.value == 3)
                editor.session.setMode("ace/mode/java");
            else 
                editor.session.setMode("ace/mode/c_cpp");
        });
         
        function submitAndCopyTheCode() {
            $("#your_code_in_the_editor").val(editor.getValue());
            document.getElementById("form_judgment").submit();
        }

    </script>
@endsection