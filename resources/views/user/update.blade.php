@extends('layouts.main')

@section('title' , 'Update user')

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
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
@endsection
