<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert your username'])!!}
		 @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
	{!!Form::label('last_name','Last name:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Insert your username'])!!}
		@if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
	{!!Form::label('nickname','NickName:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::text('nickname',null,['class'=>'form-control','placeholder'=>'Insert your username','readonly'])!!}
		 @if ($errors->has('nickname'))
            <span class="help-block">
                <strong>{{ $errors->first('nickname') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	{!!Form::label('email','E-Mail Address:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Insert your e-mail'])!!}
		 @if ($errors->has('email'))
        	<span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	{!!Form::label('password','New password:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::password('password',['class'=>'form-control','placeholder'=>'Insert your new password if you want'])!!}
	    @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	{!!Form::label('password_confirmation','Confirm password:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::password('password_confirmation',['class'=>'form-control'])!!}
		@if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
	{!!Form::label('country','Country:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!! Form::select('country',$countries,null,['placeholder' => 'Select a counntry','id'=>'country', 'class' => 'form-control']) !!}
		@if ($errors->has('country'))
            <span class="help-block">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">
	{!!Form::label('intitution','Institution:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!! Form::select('institution',[''=>''],null,['id'=>'institution', 'class' => 'form-control']) !!}
		@if ($errors->has('institution'))
            <span class="help-block">
                <strong>{{ $errors->first('institution') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
	{!!Form::label('Avatar','Avatar (120x120, <35KB):',['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-6">
		{!!Form::file('avatar')!!}
  		@if ($errors->has('avatar'))
            <span class="help-block">
                <strong>{{ $errors->first('avatar') }}</strong>
            </span>
        @endif
     </div>
</div> 