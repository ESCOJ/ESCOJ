<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert the contest name'])!!}
		 @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('organization') ? ' has-error' : '' }}">
	{!!Form::label('organization','Organization:',['class' => 'col-md-4 control-label'])!!}
	<div class="col-md-6">
		{!! Form::select('organization',$organizations,null,['placeholder' => 'Select a organization','id'=>'organization', 'class' => 'form-control select-organization']) !!}
		@if ($errors->has('organization'))
            <span class="help-block">
                <strong>{{ $errors->first('organization') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
	{!!Form::label('start_date','Start date-time:',['class' => 'col-md-4 control-label'])!!}
    {!!Form::label('end_date','End date-time:',['class' => 'col-md-4 control-label', 'style' => 'position: relative; left: 90px;' ])!!}
</div>

<div class="container" style="position: relative; left: 50px;">
    <div class='col-md-4' style="padding-right: 50px">
        <div class="form-group">
            <div class='input-group date' id='datetimepicker6'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-4' style="padding-left: 50px">
        <div class="form-group">
            <div class='input-group date' id='datetimepicker7'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
</div>