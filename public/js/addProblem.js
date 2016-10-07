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
			$('#name').focus();
		},

		error:function(msj){
			$("#div_success").html('');

			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints").html('');

			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints").fadeOut();

			$("#div_name, #div_source, #div_description, #div_input_specification,"+
			  "#div_output_specification, #div_sample_input, #div_sample_output, #div_hints").removeClass('has-error');

			$.each( msj.responseJSON, function(key,value) {
				$("#span_"+key).html('<strong>'+value+'</strong>');
				$("#div_"+key).addClass('has-error');
				$("#span_"+key).fadeIn();
			});
		}

	});
});