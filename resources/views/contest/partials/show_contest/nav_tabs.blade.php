<div class="panel panel-default">
	<div class="panel-body">
		
		<div class="line"></div>

		<div class="nav-black">
			<ul id="ul_tab" class="nav nav-tabs nav-justified">
				<li class="active"><a data-toggle="tab" href="#summary">Summary</a></li>
				<li><a data-toggle="tab" href="#problems">Problems</a></li>
				<li><a data-toggle="tab" href="#judgments" onclick = "showJudgments({{ $contest->id }})">Judgments</a></li>
				<li><a data-toggle="tab" href="#submit">Submit</a></li>
				<li><a data-toggle="tab" href="#clarifications">Clarifications</a></li>
				<li><a data-toggle="tab" href="#scoreboard" onclick = "showScoreBoard({{ $contest->id }})">ScoreBoard</a></li>
			</ul>
		</div>
		<br>

		<div class="tab-content content-nav">
			
			<!--summary tab-->
			<div id="summary" class="tab-pane fade in active">
				@include('contest.partials.show_contest.summary')
			</div>

			<!--problems tab-->
			<div id="problems" class="tab-pane fade">
				@include('contest.partials.show_contest.index_problems')
				<div id="problem">
				</div>
			</div>

			<!--judgments tab-->
			<div id="judgments" class="tab-pane fade">
				<div id="judgments_table">
				</div>
			</div>

			<!--submit tab-->
			<div id="submit" class="tab-pane fade">
				@include('contest.partials.show_contest.judgment')
			</div>

			<!--clarifications tab-->
			<div id="clarifications" class="tab-pane fade">
				hola 2
			</div>

			<!--ranking tab-->
			<div id="scoreboard" class="tab-pane fade">
				<div id="scoreboard_table">
				</div>
			</div>
			

		</div>

    </div>
</div>
