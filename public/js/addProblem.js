$("#register_problem_description").click(function(){
	var name = $("#name").val();
	var author = $("#author").val();
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
		data:{name: name ,author: author, description: description , input_specification: input_specification, 
			  output_specification: output_specification, sample_input: sample_input, sample_output: sample_output, 
			  hints: hints},

		success:function(){
			$("#msj-success").fadeIn();
		},
		error:function(msj){
			$("#msj").html(msj.responseJSON.genre);
			$("#msj-error").fadeIn();
		}
	});
});