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
            <div class="col-sm-3">
				<strong>Memory Limit(B)</strong><br><br>
				<div class="input-group">
					<input id = "ml" name = "ml" type="text" class="form-control" placeholder="Max memory" value="{{$problem->ml or ''}}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignMemoryLimit()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Source Code Size(B)</strong><br><br>
				<div class="input-group">
					<input id = "sl" name = "sl" type="text" class="form-control" placeholder="Max size source" value="{{$problem->sl or ''}}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignSourceLimit()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Time Limit Case(MS)</strong><br><br>
				<div class="input-group">
					<input id = "tlpc" name = "tlpc" type="text" class="form-control" placeholder="Max execution time per case" value="{{$problem->tlpc or ''}}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="assignTimeLimitPerCase()">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Total Time Limit(MS)</strong><br><br>
				<div class="input-group">
					<input id = "ttl" name = "ttl" type="text" class="form-control" placeholder="Max total execution time" value="{{$problem->ttl or ''}}">
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
		            	<div class="col-sm-3">
		            		
							<input name="ml_multiplier_{{ $language->id }}" id="ml_multiplier_{{ $language->id }}" type="text" class="form-control" placeholder="Memory multiplier" value="{{ number_format($language->pivot->ml_multiplier,1) }}">
						</div>
						<div class="col-sm-3">
							<input name="sl_multiplier_{{ $language->id }}" id="sl_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Source size multiplier" value="{{ number_format($language->pivot->sl_multiplier,1) }}">
						</div>
						<div class="col-sm-3">
							<input name="tlpc_multiplier_{{ $language->id }}" id="tlpc_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Execution time per case multiplier" value="{{ number_format($language->pivot->tlpc_multiplier,1) }}">
						</div>
						<div class="col-sm-3">
							<input name="ttl_multiplier_{{ $language->id }}" id="ttl_multiplier_{{ $language->id }}"type="text" class="form-control" placeholder="Total execution time multiplier" value="{{ number_format($language->pivot->ttl_multiplier,1) }}">
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
				<strong>Memory Limit(B)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Source Code Size(B)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Time Limit Case(MS)</strong><br><br>
			</div>
			<div class="col-sm-3">
				<strong>Total Time Limit(MS)</strong><br><br>
			</div>
		</div>

		<div class="panel-group">

			@foreach ($languages as $language)

				<div class="panel panel-default">
					<div class="panel-heading"><strong>{{ $language->name }}</strong></div>
					<div class="panel-body">
	            		<div class="col-sm-3">
	            			<input name="ml_{{ $language->id }}" id="ml_{{ $language->id }}" type="text" class="form-control" placeholder="Max memory" value="{{ $language->pivot->ml }}">
						</div>
						<div class="col-sm-3">
	            			<input name="sl_{{ $language->id }}" id="sl_{{ $language->id }}" type="text" class="form-control" placeholder="Max size source" value="{{ $language->pivot->sl }}">

						</div>
						<div class="col-sm-3">
							<input name="tlpc_{{ $language->id }}" id="tlpc_{{ $language->id }}" type="text" class="form-control" placeholder="Max execution time per case" value="{{  $language->pivot->tlpc }}">

						</div>
						<div class="col-sm-3">
							<input name="ttl_{{ $language->id }}" id="ttl_{{ $language->id }}" type="text" class="form-control" placeholder="Max total execution time" value="{{ $language->pivot->ttl }}">
						</div>
					</div>
			    </div> <br>

			@endforeach

		</div>
	</div>
	

</div>

