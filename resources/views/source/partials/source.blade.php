<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Insert the source name'])!!}
		 	
		@if ($errors->has('name'))
			<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
			</span>
		@endif
	</div>
</div>