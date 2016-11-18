<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#all">All</a></li>
	<li><a data-toggle="tab" href="#multipliers">Multipliers</a></li>
	<li><a data-toggle="tab" href="#each">Each</a></li>
</ul>

<div class="tab-content">
	
	<!--all tab-->
	<div id="all" class="tab-pane fade in active">
		<br>

		<div class="row">
            <div class="col-sm-3 {{ $errors->has('limits.0.ml') ? ' has-error' : '' }}">
				<strong>Memory Limit(Mb)</strong><br><br>
				<div class="input-group">
					<input id = "ml" name = "limits[0][ml]" type="text" class="form-control" placeholder="Max memory" 
					value="{{ !is_null(old('limits.0.ml')) ? old('limits.0.ml') : $problem->ml }}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignMemoryLimit()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3 {{ $errors->has('limits.0.sl') ? ' has-error' : '' }}">
				<strong>Source Code Size(Kb)</strong><br><br>
				<div class="input-group">
					<input id = "sl" name = "limits[0][sl]" type="text" class="form-control" placeholder="Max size source" 
					value="{{ !is_null(old('limits.0.sl')) ? old('limits.0.sl') : $problem->sl }}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignSourceLimit()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3 {{ $errors->has('limits.0.tlpc') ? ' has-error' : '' }}">
				<strong>Time Limit Case(Ms)</strong><br><br>
				<div class="input-group">
					<input id = "tlpc" name = "limits[0][tlpc]" type="text" class="form-control" placeholder="Max execution time per case" value="{{ !is_null(old('limits.0.tlpc')) ? old('limits.0.tlpc') : $problem->tlpc }}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignTimeLimitPerCase()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3 {{ $errors->has('limits.0.ttl') ? ' has-error' : '' }}">
				<strong>Total Time Limit(Ms)</strong><br><br>
				<div class="input-group">
					<input id = "ttl" name = "limits[0][ttl]" type="text" class="form-control" placeholder="Max total execution time" value="{{ !is_null(old('limits.0.ttl')) ? old('limits.0.ttl') : $problem->ttl }}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignTotalTimeLimit()">Apply</button>
					</span>
				</div>
            </div>
        </div>
		
		<br>
        <div class="checkbox">
		    <label><input type="checkbox" name = "use_multipliers" id = "use_multipliers"value="1">Use multipliers</label>
		</div>

		<br>
		<button class="btn btn-default" type="button" onclick="assignAllLimits()">Apply All</button>

	</div>


	<!--multipliers tab-->
	<div id="multipliers" class="tab-pane fade">
		<br>

		<div class="row">
            <div class="col-sm-2 col-xs-offset-1">
				<strong>Memory Limit</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Source Code Size</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Time Limit Case</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Total Time Limit</strong><br><br>
			</div>
		</div>

		<div class="panel-group">
				
			@foreach ($languages as $language)
				<div class="panel panel-default">
					<div class="panel-heading"><strong>{{ $language->name }}</strong></div>
					<div class="panel-body">
		            	<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.ml_multiplier') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][name]" type="hidden" value="{{ $language->name }}">

							<input name="limits[{{ $language->id }}][ml_multiplier]" id="ml_multiplier_{{ $language->id }}" type="text" class="form-control" placeholder="Memory multiplier" 
							value="{{ !is_null(old('limits.'.$language->id.'.ml_multiplier')) ? old('limits.'.$language->id.'.ml_multiplier') : number_format($language->pivot->ml_multiplier,1) }}">
						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.sl_multiplier') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][sl_multiplier]" id="sl_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Source size multiplier" 
							value="{{ !is_null(old('limits.'.$language->id.'.sl_multiplier')) ? old('limits.'.$language->id.'.sl_multiplier') : number_format($language->pivot->sl_multiplier,1) }}">
						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.tlpc_multiplier') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][tlpc_multiplier]" id="tlpc_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Execution time per case multiplier" 
							value="{{ !is_null(old('limits.'.$language->id.'.tlpc_multiplier')) ? old('limits.'.$language->id.'.tlpc_multiplier') : number_format($language->pivot->tlpc_multiplier,1) }}">
						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.ttl_multiplier') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][ttl_multiplier]" id="ttl_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Total execution time multiplier" 
							value="{{ !is_null(old('limits.'.$language->id.'.ttl_multiplier')) ? old('limits.'.$language->id.'.ttl_multiplier') : number_format($language->pivot->ttl_multiplier,1) }}">
						</div>
					</div>
			    </div> <br>

			@endforeach

		</div>
		<button class="btn btn-default" type="button" onclick="assignAllMultipliers()">Apply All</button>

	</div>
	{!! Form::select('ids',$ids,null,['id' => 'languages', 'style' => 'visibility:hidden']) !!}


	<!--each tab-->
	<div id="each" class="tab-pane fade">
		<br>

		<div class="row">
            <div class="col-sm-3">
				<strong>Memory Limit(Mb)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Source Code Size(Kb)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Time Limit Case(Ms)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Total Time Limit(Ms)</strong><br><br>
			</div>
		</div>

		<div class="panel-group">

			@foreach ($languages as $language)

				<div class="panel panel-default">
					<div class="panel-heading"><strong>{{ $language->name }}</strong></div>
					<div class="panel-body">
	            		<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.ml') ? ' has-error' : '' }}">
	            			<input name="limits[{{ $language->id }}][ml]" id="ml_{{ $language->id }}" type="text" class="form-control" placeholder="Max memory" 
	            			value="{{ !is_null(old('limits.'.$language->id.'.ml')) ? old('limits.'.$language->id.'.ml') : $language->pivot->ml }}">
						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.sl') ? ' has-error' : '' }}">
	            			<input name="limits[{{ $language->id }}][sl]" id="sl_{{ $language->id }}" type="text" class="form-control" placeholder="Max size source" 
	            			value="{{ !is_null(old('limits.'.$language->id.'.sl')) ? old('limits.'.$language->id.'.sl') : $language->pivot->sl }}">

						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.tlpc') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][tlpc]" id="tlpc_{{ $language->id }}" type="text" class="form-control" placeholder="Max execution time per case" 
							value="{{ !is_null(old('limits.'.$language->id.'.tlpc')) ? old('limits.'.$language->id.'.tlpc') : $language->pivot->tlpc }}">

						</div>
						<div class="col-sm-3 {{ $errors->has('limits.'.$language->id.'.ttl') ? ' has-error' : '' }}">
							<input name="limits[{{ $language->id }}][ttl]" id="ttl_{{ $language->id }}" type="text" class="form-control" placeholder="Max total execution time" 
							value="{{ !is_null(old('limits.'.$language->id.'.ttl')) ? old('limits.'.$language->id.'.ttl') : $language->pivot->ttl }}">
						</div>
					</div>
			    </div> <br>

			@endforeach

		</div>
	</div>
	

</div>

