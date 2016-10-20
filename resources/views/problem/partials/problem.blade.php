<div id = "div_name" class="form-group">
	{!!Form::label('name','Title:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Insert the problem name'])!!}
		 	
		 	<span id = "span_name" class="help-block" style="display:none">
                
            </span>
	</div>
</div>

<div id = "div_source" class="form-group">
	{!!Form::label('source','Author:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		@if(isset($problem))
        	{!! Form::select('source',$sources,$problem->source_id,['id'=>'source', 'class' => 'form-control select-source','placeholder'=>'Select the source']) !!}
        	<input type="hidden" name="id" id="problem_id" value="{{ $problem->id }}">
        @else
			{!! Form::select('source',$sources,null,['id'=>'source', 'class' => 'form-control select-source','placeholder'=>'Select the source']) !!}
        @endif
        <span id = "span_source" class="help-block" style="display:none">

        </span>
	</div>
</div>

<div id = "div_points" class="form-group">
	{!!Form::label('points','Points:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::text('points',null,['id'=>'points','class'=>'form-control ','placeholder'=>'Insert the points (1-100)'])!!}
		 	
		 	<span id = "span_points" class="help-block" style="display:none">
                
            </span>
	</div>
</div>


<!--Description-->
<div id = "div_description" class="form-group">
	<div class="row">
	      <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Problem Description</center></label></h4>
	</div>
	{!!Form::label('description','Description:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('description',null,['id'=>'description','class'=>'form-control textarea-content','placeholder'=>'Problem description...','rows'=> '15'])!!}
		<span id = "span_description" class="help-block" style="display:none">

        </span>

	</div>
</div>

<div id = "div_input_specification" class="form-group">
	{!!Form::label('input_specification','Input specification:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('input_specification',null,['id'=>'input_specification','class'=>'form-control textarea-content','placeholder'=>'Input specification...','rows'=> '2'])!!}
		<span id = "span_input_specification" class="help-block" style="display:none">

        </span>
	</div>
</div>

<div id = "div_output_specification" class="form-group">
	{!!Form::label('output_specification','Output specification:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('output_specification',null,['id'=>'output_specification','class'=>'form-control textarea-content','placeholder'=>'Output specification...','rows'=> '2'])!!}
		<span id = "span_output_specification" class="help-block" style="display:none">

        </span>
	</div>
</div>

<div id = "div_sample_input" class="form-group">
	{!!Form::label('sample_input','Sample input:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('sample_input',null,['id'=>'sample_input','class'=>'form-control textarea-content','placeholder'=>'Sample input...','rows'=> '2'])!!}
		<span id = "span_sample_input" class="help-block" style="display:none">

        </span>
	</div>
</div>

<div id = "div_sample_output" class="form-group">
	{!!Form::label('sample_output','Sample output:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('sample_output',null,['id'=>'sample_output','class'=>'form-control textarea-content','placeholder'=>'Sample output...','rows'=> '2'])!!}
		<span id = "span_sample_output" class="help-block" style="display:none">

        </span>
	</div>
</div>

<div id = "div_hints" class="form-group">
	{!!Form::label('hints','Hints:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		{!!Form::textArea('hints',null,['id'=>'hints','class'=>'form-control textarea-content','placeholder'=>'Hints...','rows'=> '2'])!!}
		<span id = "span_hints" class="help-block" style="display:none">

        </span>
	</div>
</div>


<!--Languages-->

<div id = "div_languages" class="form-group">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Languages</center></label></h4>
	</div>
	<br>
	
	{!!Form::label('languages','Available Languages:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">

		@foreach ($languages as $language)

			@if ( ($loop->index)%4 == 0 )
				<div class="row">
			@endif
		  	<div class="col-sm-3">
				
				@if(isset($languages_selected) and array_has($languages_selected,$language->id))
					<label><input type="checkbox" name = "{{ $language->name }}" id = "{{ $language->name }}"  value="{{ $language->id }}" checked>
		    		&nbsp;&nbsp;&nbsp;{{ $language->name }}
		    		</label>
				@else
			    	<label><input type="checkbox" name = "{{ $language->name }}" id = "{{ $language->name }}"  value="{{ $language->id }}">
			    		&nbsp;&nbsp;&nbsp;{{ $language->name }}
			    	</label>
		    	@endif
		    </div>

		    @if ( (($loop->index)%3 == 0) and (!$loop->first) )
				</div>
			@endif
		@endforeach

		<div class="row">
        	<div class="col-sm-3">
		    	<label><input type="checkbox" name = "All" id = "All"  value="0">
		    		&nbsp;&nbsp;&nbsp;All
		    	</label>
			</div>
		</div>

		<span id = "span_languages" class="help-block" style="display:none">

        </span>
	</div>
</div>


<!--Tags-->

<div id = "div_tags" class="form-group">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Tags</center></label></h4>
	</div>
	<br>
	
	{!!Form::label('tags','Classification By Tags:',['class' => 'col-md-3 control-label'])!!}
	<div class="col-md-7">
		@if(isset($tags_selected))
			{!! Form::select('tags[]',$tags,$tags_selected,['id'=>'tags', 'class' => 'form-control select-tag','data-placeholder'=>'Select tags and their levels ' ,'multiple' => true]) !!}
		@else
        	{!! Form::select('tags[]',$tags,null,['id'=>'tags', 'class' => 'form-control select-tag','data-placeholder'=>'Select tags and their levels ' ,'multiple' => true]) !!}
        @endif
		<span id = "span_tags" class="help-block" style="display:none">

        </span>
	</div>
</div>

<!--Other Options-->

<div id = "div_other" class="form-group">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Other Options</center></label></h4>
	</div>
	<br>
	
	{!!Form::label('other','Other Options:',['class' => 'col-md-3 control-label'])!!}
	
	<div class="col-md-7">
		<div class="row">
			<div class="checkbox">
				 @if(isset($problem) and $problem->multidata)
	    			<label><input id="multidata" name="multidata" type="checkbox" value="" checked="checked"><strong>Multidata</strong></label>
	    		 @else
					<label><input id="multidata" name="multidata" type="checkbox" value=""><strong>Multidata</strong></label>
	    		@endif
			</div>
			<div class="checkbox">
				 @if(isset($problem) and $problem->enable)
			     	<label><input id="enable" name="enable" type="checkbox" value="" checked="checked"><strong>Enable</strong></label>
			     @else
					<label><input id="enable" name="enable" type="checkbox" value=""><strong>Enable</strong></label>
			     @endif
			</div>
		</div>
		<span id = "span_other" class="help-block" style="display:none">

        </span>
	</div>
</div>

<!-- div to display success message-->
<div id = "div_success" class="col-md-6 col-md-offset-3" style="display:none"> </div>








               

        
 