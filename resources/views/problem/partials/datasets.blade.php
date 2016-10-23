<!--Datasets-->

<div class="form-group">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Datasets</center></label>
	    </h4>
	    <div class="col-md-8 col-md-offset-2 text-center">
	        <h5>
	            @include('flash::message')
	        </h5>
    	</div> 
	</div>
	<br>

	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
            <div class="panel-heading"><strong><center>Datasets</center></strong></div>
                <div class="panel-body">
					
					@if($problem->dataset)
	                  	<div class="form-group">
						    {!!Form::label('existing_dataset','Existing Dataset:',['class' => 'col-md-3 control-label file'])!!}
						    <div class="col-md-7">
						        <div class="input-group">
									<input id = "existing_dataset" name = "existing_dataset" type="text" class="form-control" value="{{ 'problem_' .$problem->id. '_dataset.zip'}}" disabled="disabled">
									<div class="input-group-btn">
										<!--Delete-->
										{!! Html::decode(link_to_route('problem.deleteDatasets', $title = '<span class="glyphicon glyphicon-trash"></span> Delete', $parameters = ['id'=> $problem->id ], $attributes = [ 'class' => 'btn btn-danger' ])) !!}
										<!--Download-->
										{!! Html::decode(link_to_action('ProblemController@downloadDatasets', $title = '<span class="glyphicon glyphicon-download"></span> Download', $parameters = ['id'=> $problem->id ], $attributes = [ 'class' => 'btn btn-primary' ])) !!}
										
									</div>
								</div>

						     </div>
						</div>
					@endif

					<div class="form-group{{ $errors->has('dataset') ? ' has-error' : '' }}">
					    {!!Form::label('dataset','Zip File:',['class' => 'col-md-3 control-label file'])!!}
					    <div class="col-md-7">
					        {!! Form::file('dataset') !!}
					        @if ($errors->has('dataset'))
					            <span class="help-block">
					                <strong>{{ $errors->first('dataset') }}</strong>
					            </span>
					        @endif
					     </div>
					</div>

				</div>
		</div>
	</div>

</div>