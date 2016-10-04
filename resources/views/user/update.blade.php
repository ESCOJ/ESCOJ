@extends('layouts.main')

@section('title' , 'Update user')

@section('styles')
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
@endsection  

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Update</div>
               		<div class="panel-body">
						{!!Form::model($user,['action'=> 'Auth\RegisterController@update','method'=>'PUT','files' => true,'class' => 'form-horizontal'])!!}
							@include('user.partials.user')
							<div class="form-group">
                            	<div class="col-md-6 col-md-offset-4">
									{!!Form::submit('Update',['class'=>'btn btn-primary'])!!}
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
	{!!Html::script('js/dropdown.js') !!}
    {!!Html::script('plugins/fileinput/js/fileinput.min.js')!!}
    <script type="text/javascript">
         $("#avatar").fileinput({
            maxFileSize : 35,
            msgProgress : 'Loading {percent}%',
            previewClass : 'file_preview',
            previewFileType : "image",
            browseClass : "btn btn-primary",
            browseLabel : "Pick image",
            browseIcon : '<i class="fa fa-picture-o"></i>&nbsp;',
            removeClass : "btn btn-default",
            removeLabel : "Delete",
            removeIcon : '<i class="fa fa-trash"></i>',
            showUpload: false,
        });
    </script>
@endsection
