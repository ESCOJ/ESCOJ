$("#register_problem_description").click(function(){
	
	var name = $("#name").val();
	var source = $("#source").val();
	var description = $("#description").val();
	var input_specification = $("#input_specification").val();
	var output_specification = $("#output_specification").val();
	var sample_input = $("#sample_input").val();
	var sample_output = $("#sample_output").val();
	var hints = $("#hints").val();

	var route = "http://www.escoj.com/problem";
	var token = $("#token").val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data:{name: name ,source: source, description: description , input_specification: input_specification, 
			  output_specification: output_specification, sample_input: sample_input, sample_output: sample_output, 
			  hints: hints},

		success:function(msj){
			$("#div_error").html('');
			$("#div_success").html('');
			alert(msj.responseJSON.name)
			var msj_success = 
				'<div id = "msj-success" class="alert alert-success alert-dismissible" role="alert" >'+
			  		'<button type="button" class="close" data-dismiss="alert" aria-label="Close" >'+
			  			'<span aria-hidden="true">&times;</span>'+
			  		'</button>'+
			  		'<p><strong><center>' + msj.message  + '</center></strong</p>'+
			  	'</div>';

			$("#div_success").append(msj_success);
			$("#div_success").fadeIn();
			$('#div_success').focus();
		},
		error:function(msj){
			$("#div_error").html('');
			$("#div_success").html('');
			$("#_email")
			$.each( msj.responseJSON, function(key,value) {
				alert(value);
			});




			var msj_error = 
				'<div id = "msj-error" class="alert alert-danger alert-dismissible" role="alert" >'+
			  		'<button type="button" class="close" data-dismiss="alert" aria-label="Close" >'+
			  			'<span aria-hidden="true">&times;</span>'+
			  		'</button>';

		  	if( msj.responseJSON.name)
		  		msj_error += '<p><strong><center>*' + msj.responseJSON.name  + '</center></strong</p>';
		  	if( msj.responseJSON.source)
				msj_error +='<p><strong><center>*' + msj.responseJSON.source + '</center></strong</p>';
			if( msj.responseJSON.description)
				msj_error +='<p><strong><center>*' + msj.responseJSON.description + '</center></strong</p>';
			if( msj.responseJSON.input_specification)
				msj_error +='<p><strong><center>*' + msj.responseJSON.input_specification + '</center></strong</p>';
			if( msj.responseJSON.output_specification)
				msj_error +='<p><strong><center>*' + msj.responseJSON.output_specification + '</center></strong</p>';
			if( msj.responseJSON.sample_input)
				msj_error +='<p><strong><center>*' + msj.responseJSON.sample_input + '</center></strong</p>';
			if( msj.responseJSON.sample_output)
				msj_error +='<p><strong><center>*' + msj.responseJSON.sample_output + '</center></strong</p>';
			if( msj.responseJSON.hints)
				msj_error +='<p><strong><center>*' + msj.responseJSON.hints + '</center></strong</p>';
			
			msj_error += '</div>';

			$("#div_error").append(msj_error);
			$("#div_error").fadeIn();
		}
	});
});