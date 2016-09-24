@extends('layouts.main')
	@section('title' , 'Update user');
	@section('content')
		{!!Form::model($user,['action'=> 'UserController@update','method'=>'PUT','files' => true])!!}
			@include('user.partials.user')
			{!!Form::submit('Update',['class'=>'btn btn-primary'])!!}
		{!!Form::close()!!}
	@endsection