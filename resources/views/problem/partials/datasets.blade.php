<!--Datasets-->

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Datasets</center></label></h4>
	</div>
	<br>
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
            <div class="panel-heading"><strong><center>Datasets</center></strong></div>
                <div class="panel-body">
					<div class="form-group{{ $errors->has('dataset') ? ' has-error' : '' }}">
					    {!!Form::label('dataset','Source code:',['class' => 'col-md-3 control-label file'])!!}
					    <div class="col-md-7">
					        {!! Form::file('dataset', array('multiple'=>true)) !!}
					        @if ($errors->has('dataset'))
					            <span class="help-block">
					                <strong>{{ $errors->first('dataset') }}</strong>
					            </span>
					        @endif
					     </div>
					</div>					
				</div>
		</div>

		<div class="checkbox">
		    <label><input type="checkbox" value=""><strong>Multidata</strong></label>
		</div>
		<div class="checkbox">
		    <label><input type="checkbox" value=""><strong>Enable</strong></label>
		</div>

		 @if ($errors->has('email'))
        	<span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
</div>