<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert the problem name'])!!}
		 @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
	{!!Form::label('author','Author:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('author',null,['class'=>'form-control','placeholder'=>'Insert the author'])!!}
		@if ($errors->has('author'))
            <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
        @endif
	</div>
</div>

<!--Description-->
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
	<div class="row">
	      <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Problem Description</center></label></h4>
	</div>
	{!!Form::label('description','Description:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('description',null,['class'=>'form-control textarea-content','placeholder'=>'Problem description...','rows'=> '15'])!!}
		 @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('input_specification') ? ' has-error' : '' }}">
	{!!Form::label('input_specification','Input specification:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('input_specification',null,['class'=>'form-control textarea-content','placeholder'=>'Input specification...','rows'=> '2'])!!}
		 @if ($errors->has('input_specification'))
            <span class="help-block">
                <strong>{{ $errors->first('input_specification') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('output_specification') ? ' has-error' : '' }}">
	{!!Form::label('output_specification','Output specification:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('output_specification',null,['class'=>'form-control textarea-content','placeholder'=>'Output specification...','rows'=> '2'])!!}
		 @if ($errors->has('output_specification'))
            <span class="help-block">
                <strong>{{ $errors->first('output_specification') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('sample_input') ? ' has-error' : '' }}">
	{!!Form::label('sample_input','Sample input:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('sample_input',null,['class'=>'form-control textarea-content','placeholder'=>'Sample input...','rows'=> '2'])!!}
		 @if ($errors->has('sample_input'))
            <span class="help-block">
                <strong>{{ $errors->first('sample_input') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('sample_output') ? ' has-error' : '' }}">
	{!!Form::label('sample_output','Sample output:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('sample_output',null,['class'=>'form-control textarea-content','placeholder'=>'Sample output...','rows'=> '2'])!!}
		 @if ($errors->has('sample_output'))
            <span class="help-block">
                <strong>{{ $errors->first('sample_output') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('hints') ? ' has-error' : '' }}">
	{!!Form::label('hints','Hints:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('hints',null,['class'=>'form-control textarea-content','placeholder'=>'Hints...','rows'=> '2'])!!}
		 @if ($errors->has('hints'))
            <span class="help-block">
                <strong>{{ $errors->first('hints') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Limits</center></label></h4>
	</div>
	{!!Form::label('email','E-Mail Address:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Insert your e-mail'])!!}
		 @if ($errors->has('email'))
        	<span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	{!!Form::label('password','New password:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::password('password',['class'=>'form-control','placeholder'=>'Insert your new password if you want'])!!}
	    @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
</div>
<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	{!!Form::label('password_confirmation','Confirm password:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::password('password_confirmation',['class'=>'form-control'])!!}
		@if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
	{!!Form::label('Avatar','Avatar (120x120, <35KB):',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
		{!!Form::file('avatar')!!}
  		@if ($errors->has('avatar'))
            <span class="help-block">
                <strong>{{ $errors->first('avatar') }}</strong>
            </span>
        @endif
     </div>
</div> 
