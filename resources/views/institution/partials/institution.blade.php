<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Insert the organization name'])!!}
		 	
		@if ($errors->has('name'))
			<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
			</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
	{!!Form::label('country','Country:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		@if(isset($institution))
			{!! Form::select('country',$countries,$institution->country->id,['placeholder' => 'Select a counntry','id'=>'country', 'class' => 'form-control']) !!}
		@else
			{!! Form::select('country',$countries,null,['placeholder' => 'Select a counntry','id'=>'country', 'class' => 'form-control']) !!}
		@endif
		@if ($errors->has('country'))
            <span class="help-block">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        @endif
	</div>
</div>