{!!Form::open(['route' => 'user.changeUserType', 'method' => 'PUT'])!!}

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Change user role</h4>
			</div>
				<input type="hidden" id="id" name="id">
			<div class="modal-body">
				
	
				<div class="form-group">
					{!!Form::label('nickname','NickName:',[])!!}
					{!!Form::text('nickname',null,['class'=>'form-control','placeholder'=>'nickname','readonly'])!!}
				</div>

				<div class="form-group">
					{!!Form::label('nickname','NickName:',[])!!}
					{!! Form::select('type',$roles,null,['placeholder' => 'Select a role','id'=>'type', 'class' => 'form-control']) !!}
				</div>



			</div>

			<div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-save"></span> Update
                </button>
			</div>

		</div>
	</div>
</div>

{!! Form::close() !!}