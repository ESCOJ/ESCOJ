<div class="form-group">
	{!!Form::label('name','Name:')!!}
	{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert your username'])!!}
</div>
<div class="form-group">
	{!!Form::label('last_name','Last name:')!!}
	{!!Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Insert your username'])!!}
</div>
<div class="form-group">
	{!!Form::label('nickname','NickName:')!!}
	{!!Form::text('nickname',null,['class'=>'form-control','placeholder'=>'Insert your username'])!!}
</div>

<div class="form-group">
	{!!Form::label('email','E-Mail Address:')!!}
	{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Insert your e-mail'])!!}
</div>
<div class="form-group">
	{!!Form::label('password','New password:')!!}
	{!!Form::password('password',['class'=>'form-control','placeholder'=>'Insert your password'])!!}
</div>
<div class="form-group">
	{!!Form::label('password-confirm','Confirm password:')!!}
	{!!Form::password('password-confirm',['class'=>'form-control'])!!}
</div>
<div class="form-group">
	{!!Form::label('countrys','Country:')!!}
	{!! Form::select('country',$countries,null,['placeholder' => 'Select a counntry','id'=>'country', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
	{!!Form::label('intitutions','Institution:')!!}
	{!! Form::select('institution',[''=>''],null,['id'=>'institution', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
	{!!Form::label('Avatar','Avatar (120x120, <35KB):')!!}
	{!!Form::file('path')!!}
</div>