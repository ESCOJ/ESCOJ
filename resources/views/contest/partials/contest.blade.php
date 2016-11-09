<!--Name-->
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!!Form::label('name','Name:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert the contest name'])!!}
		 @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
</div>

<!--Organization-->
<div class="form-group{{ $errors->has('organization_id') ? ' has-error' : '' }}">
	{!!Form::label('organization_id','Organization:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
        {!! Form::select('organization_id',$organizations,null,['placeholder' => 'Select a organization','id'=>'organization_id', 'class' => 'form-control select-chosen']) !!}
		@if ($errors->has('organization_id'))
            <span class="help-block">
                <strong>{{ $errors->first('organization_id') }}</strong>
            </span>
        @endif

	</div>
</div>

<!--Penalization-->
<div class="form-group{{ $errors->has('penalization') ? ' has-error' : '' }}">
    {!!Form::label('penalization','Penalization Time:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::text('penalization',null,['class'=>'form-control','placeholder'=>'Insert penalization (0-60 mins)'])!!}
         @if ($errors->has('penalization'))
            <span class="help-block">
                <strong>{{ $errors->first('penalization') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Frozen-TIme-->
<div class="form-group{{ $errors->has('frozen_time') ? ' has-error' : '' }}">
    {!!Form::label('frozen_time','Frozen Time:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::text('frozen_time',null,['class'=>'form-control','placeholder'=>'Insert Frozen Time (mins)'])!!}
         @if ($errors->has('frozen_time'))
            <span class="help-block">
                <strong>{{ $errors->first('frozen_time') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Access type-->
<div class="form-group{{ $errors->has('access_type') ? ' has-error' : '' }}">   
    {!!Form::label('access_type','Access Type:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!! Form::select('access_type',['public' => 'Public', 'private' => 'Private'],null,['placeholder' => 'Select Access Type','id'=>'access_type', 'class' => 'form-control select-chosen']) !!}
        @if ($errors->has('access_type'))
            <span class="help-block">
                <strong>{{ $errors->first('access_type') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Description-->
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!!Form::label('description','Description:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::textArea('description',null,['id'=>'description','class'=>'form-control textarea-content','placeholder'=>'Contest description...','rows'=> '15'])!!}
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Dates contest-->
<div class="form-group">
    <div class="{{ $errors->has('start_date') ? ' has-error' : '' }}">
        {!!Form::label('start_date','Start date-time:',['class' => 'col-md-4 control-label'])!!}
    </div>
    <div class="{{ $errors->has('end_date') ? ' has-error' : '' }}">
        {!!Form::label('end_date','End date-time:',['class' => 'col-md-4 control-label', 'style' => 'position: relative; left: 100px;' ])!!}
    </div>
</div>

<div class="container" style="position: relative; left: 60px;">
    <div class='col-md-4' style="padding-right: 50px">
        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <div class='input-group date' id='start_date_datetimepicker'>
                {!!Form::text('start_date',null,['class'=>'form-control'])!!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class='col-md-4' style="padding-left: 50px">
        <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <div class='input-group date' id='end_date_datetimepicker'>
                {!!Form::text('end_date',null,['class'=>'form-control'])!!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>


<!--offcontest-->
<div class="form-group{{ $errors->has('offcontest') ? ' has-error' : '' }}">
    <div class="row">
        <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Offcontest</center></label></h4>
    </div>
    <br>
    <div class="col-md-offset-5 col-md-7">
        <div class="row">
            <div class="col-sm-3">
                <label>{!! Form::checkbox('offcontest', '1')!!}
                    &nbsp;&nbsp;&nbsp;Offcontest
                </label>
            </div>
        </div>

        @if ($errors->has('offcontest'))
            <span class="help-block">
                <strong>{{ $errors->first('offcontest') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Penalization Offcontest-->
<div class="form-group{{ $errors->has('offcontest_penalization') ? ' has-error' : '' }}">
    {!!Form::label('offcontest_penalization','Penalization Time:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::text('offcontest_penalization',null,['class'=>'form-control','placeholder'=>'Insert penalization (0-60 mins)'])!!}
         @if ($errors->has('offcontest_penalization'))
            <span class="help-block">
                <strong>{{ $errors->first('offcontest_penalization') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--Dates Offcontest-->
<div class="form-group">
    <div class="{{ $errors->has('offcontest_start_date') ? ' has-error' : '' }}">
        {!!Form::label('offcontest_start_date','Start date-time:',['class' => 'col-md-4 control-label'])!!}
    </div>
    <div class="{{ $errors->has('offcontest_end_date') ? ' has-error' : '' }}">
        {!!Form::label('offcontest_end_date','End date-time:',['class' => 'col-md-4 control-label', 'style' => 'position: relative; left: 100px;' ])!!}
    </div>
</div>
<div class="container" style="position: relative; left: 60px;">
    <div class='col-md-4' style="padding-right: 50px">
        <div class="form-group{{ $errors->has('offcontest_start_date') ? ' has-error' : '' }}">
            <div class='input-group date' id='offcontest_start_date_datetimepicker'>
                {!!Form::text('offcontest_start_date',null,['class'=>'form-control'])!!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            @if ($errors->has('offcontest_start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('offcontest_start_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class='col-md-4' style="padding-left: 50px">
        <div class="form-group{{ $errors->has('offcontest_end_date') ? ' has-error' : '' }}">
            <div class='input-group date' id='offcontest_end_date_datetimepicker'>
                {!!Form::text('offcontest_end_date',null,['class'=>'form-control'])!!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            @if ($errors->has('offcontest_end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('offcontest_end_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<!--problems-->
<div class="form-group{{ $errors->has('problems') ? ' has-error' : '' }}">
    <div class="row">
        <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Problems</center></label></h4>
    </div>
    <br>
    {!!Form::label('problems','Problems:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
       
        @if(isset($contest))
            {!! Form::select('problems[]',$problems,$problems_selected,['id'=>'problems', 'class' => 'form-control select-chosen-mult','data-placeholder'=>'Select problems' ,'multiple' => true]) !!}
        @else
            {!! Form::select('problems[]',$problems,null,['id'=>'problems', 'class' => 'form-control select-chosen-mult','data-placeholder'=>'Select problems' ,'multiple' => true]) !!}
        @endif
        @if ($errors->has('problems'))
            <span class="help-block">
                <strong>{{ $errors->first('problems') }}</strong>
            </span>
        @endif
    </div>
</div>

<!--users-->
<div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
    <div class="row">
        <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>users</center></label></h4>
    </div>
    <br>
    {!!Form::label('users','users:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">

        @if(isset($contest))
            {!! Form::select('users[]',$users,$users_selected,['id'=>'users', 'class' => 'form-control select-chosen-mult','data-placeholder'=>'Select users' ,'multiple' => true]) !!}
        @else
            {!! Form::select('users[]',$users,null,['id'=>'users', 'class' => 'form-control select-chosen-mult','data-placeholder'=>'Select users' ,'multiple' => true]) !!}
        @endif

        @if ($errors->has('users'))
            <span class="help-block">
                <strong>{{ $errors->first('users') }}</strong>
            </span>
        @endif
    </div>
</div>
