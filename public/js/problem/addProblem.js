function createProblemDescription(){
	
	var action = 'create_problem';
	var name = $("#name").val();
	var source = $("#source").val();
	var points = $("#points").val();
	var description = $("#description").val();
	var input_specification = $("#input_specification").val();
	var output_specification = $("#output_specification").val();
	var sample_input = $("#sample_input").val();
	var sample_output = $("#sample_output").val();
	var hints = $("#hints").val();
	var languages = {};
	var multidata = 0;
	var enable = 0;
	var id = 0;

	var route = "http://www.escoj.com/problem";
	var type = "POST";

	var tags = $("#tags").val();
	if( window.location != "http://www.escoj.com/problem/create"){
		route = "http://www.escoj.com/problem/update/" + $("#problem_id").val();
		type = "PUT";
		action = 'update_problem'
		id = $("#problem_id").val();
	}

	var token = $("#token").val();

	var checkbox_languages = $("#div_languages").find('input[type=checkbox]');

    checkbox_languages.each(function(e){
      if($(this).is(':checked') ){
        var name = $(this).attr("name");
        var id = $(this).attr("value");
        languages[name] = id ;
      }
    });

    if($("#multidata").is(':checked') )
     	multidata = 1;
    if($("#enable").is(':checked') )
     	enable = 1;

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: type,
		dataType: 'json',
		data:{action : action, name: name ,source: source, points: points, description: description , input_specification: input_specification, 
			  output_specification: output_specification, sample_input: sample_input, sample_output: sample_output, 
			  hints: hints, languages: languages, tags: tags, multidata: multidata, enable: enable, id: id},

		success:function(msj){
			$("#div_success").html('');
			
			$("#span_name, #span_source, #span_points, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").html('');

			$("#span_name, #span_source, #span_points, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").fadeOut();

			$("#div_name, #div_source, #div_points, #div_description, #div_input_specification,"+
			  "#div_output_specification, #div_sample_input, #div_sample_output, #div_hints, #div_languages, #div_tags").removeClass('has-error');

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

			if(msj.redirect != 'not')
				setTimeout(function () {
	                window.location.replace(msj.redirect);
				}, 3500);
			else
				$('div.alert').delay(5000).fadeOut(350);


		},

		error:function(msj){
			$("#div_success").html('');

			$("#span_name, #span_source, #span_points, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_points, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").html('');

			$("#span_name, #span_source, #span_points, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").fadeOut();

			$("#div_name, #div_source, #div_points, #div_description, #div_input_specification,"+
			  "#div_output_specification, #div_sample_input, #div_sample_output, #div_hints, #div_languages, #div_tags").removeClass('has-error');

			var flag = true;
			$.each( msj.responseJSON, function(key,value) {
				$("#span_"+key).html('<strong>'+value+'</strong>');
				$("#div_"+key).addClass('has-error');
				$("#span_"+key).fadeIn();
				if(flag){
					$("#div_"+key).attr("tabindex",-1).focus();
					flag = false;
				}
			});
		}

	});
};