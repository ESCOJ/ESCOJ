<!--Limits-->
<div class="form-group{{ $errors->has('tlpc') ? ' has-error' : '' }}">
	<div class="row">
	    <h4><label for="input" class="col-sm-10 col-sm-offset-1 label label-primary"><center>Limits</center></label></h4>
	    <div class="col-md-8 col-md-offset-2 text-center">
	        <h5>
	            @include('flash::message')
	        </h5>
    	</div>  
	</div>
	<br>
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
            <div class="panel-heading"><strong><center>Limits</center></strong></div>
                <div class="panel-body">

					@include('problem.partials.limitscontent')

				</div>
		</div>
        @if(count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
		  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  		<ul>
		  			@foreach($errors->all() as $error)
		  				<li>{!!$error!!}</li>
		  			@endforeach
		  		</ul>
		  	</div>
		@endif
	</div>
</div>








