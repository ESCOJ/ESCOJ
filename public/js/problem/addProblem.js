function createProblemDescription(){
	
	var action = 'create_problem';
	var name = $("#name").val();
	var source = $("#source").val();
	var description = $("#description").val();
	var input_specification = $("#input_specification").val();
	var output_specification = $("#output_specification").val();
	var sample_input = $("#sample_input").val();
	var sample_output = $("#sample_output").val();
	var hints = $("#hints").val();
	var languages = {};
	var tags = $("#tags").val();

	var route = "http://www.escoj.com/problem";
	var token = $("#token").val();


	var checkbox = $("#div_languages").find('input[type=checkbox]');

    checkbox.each(function(e){
      if($(this).is(':checked') ){
        var name = $(this).attr("name");
        var id = $(this).attr("value");
        languages[name] = id ;
      }
    });

    /*for( key in languages){
    	alert('Es el lenguaje ' + key + ' y es ' + languages[key]);
    }*/

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data:{action : action, name: name ,source: source, description: description , input_specification: input_specification, 
			  output_specification: output_specification, sample_input: sample_input, sample_output: sample_output, 
			  hints: hints, languages: languages, tags: tags},

		success:function(msj){
			$("#div_success").html('');
			
			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").html('');

			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").fadeOut();

			$("#div_name, #div_source, #div_description, #div_input_specification,"+
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

			setTimeout(function () {
                window.location.replace(msj.redirect);
			}, 3500);


		},

		error:function(msj){
			$("#div_success").html('');

			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").html('');

			$("#span_name, #span_source, #span_description, #span_input_specification,"+
			  "#span_output_specification, #span_sample_input, #span_sample_output, #span_hints, #span_languages, #span_tags").fadeOut();

			$("#div_name, #div_source, #div_description, #div_input_specification,"+
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