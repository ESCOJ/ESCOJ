<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#all">All</a></li>
	<li><a data-toggle="tab" href="#each">Each</a></li>
	<li><a data-toggle="tab" href="#multipliers">Multipliers</a></li>
</ul>

<div class="tab-content">
	
	<!--all tab-->
	<div id="all" class="tab-pane fade in active">
		<br>

		<div class="row">
            <div class="col-sm-3">
				<strong>Memory Limit(B)</strong><br><br>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Max memory">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Source Code Size(B)</strong><br><br>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Max size source">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Time Limit Case(MS)</strong><br><br>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Max execution time per case">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Apply</button>
					</span>
				</div>
            </div>
            <div class="col-sm-3">
				<strong>Total Time Limit(MS)</strong><br><br>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Max total execution time">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Apply</button>
					</span>
				</div>
            </div>
        </div>
		
		<br>
        <div class="checkbox">
		    <label><input type="checkbox" value="">Use multipliers</label>
		</div>

		<br>
		<button class="btn btn-default" type="button">Save All</button>

	</div>

	
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
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>C</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max memory">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max size source">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max execution time per case">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max total execution time">
					</div>
	
				</div>
		    </div> <br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>C++</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max memory">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max size source">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max execution time per case">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max total execution time">
					</div>
	
				</div>
		    </div><br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>Java</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max memory">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max size source">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max execution time per case">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max total execution time">
					</div>
	
				</div>
		    </div><br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>Python</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max memory">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max size source">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max execution time per case">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Max total execution time">
					</div>
	
				</div>
		    </div>
		</div>
		<br>
		<button class="btn btn-default" type="button">Save</button>

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
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>C</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Memory multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Source size multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Execution time per case multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Ttal execution time multiplier">
					</div>
	
				</div>
		    </div><br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>C++</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Memory multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Source size multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Execution time per case multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Ttal execution time multiplier">
					</div>
	
				</div>
		    </div><br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>Java</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Memory multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Source size multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Execution time per case multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Ttal execution time multiplier">
					</div>
	
				</div>
		    </div><br>
		    <div class="panel panel-default">
				<div class="panel-heading"><strong>Python</strong></div>
				<div class="panel-body">
            		<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Memory multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Source size multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Execution time per case multiplier">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Ttal execution time multiplier">
					</div>
	
				</div>
		    </div>
		</div>
		
		<br>
		<button class="btn btn-default" type="button">Save All</button>

	</div>

</div>








