$("#country").change(event => {
	$("#institution").empty();
	$.get(`contestant/institutions/${event.target.value}`, function(res){
		res.forEach(element => {
			$("#institution").append(`<option value=${element.id}> ${element.name} </option>`);
		});
         $("#institution").chosen({ width: "95%" });
		 $("#institution").trigger("chosen:updated");
	});
});

$(document).ready(function(){
    if( $('#country').val() >= 1 ){
    	$("#institution").empty();
		$.get(`http://www.escoj.com/contestant/institutions/`+$('#country').val(), function(res){
			res.forEach(element => {
				$("#institution").append(`<option value=${element.id}> ${element.name} </option>`);
			});
	         $("#institution").chosen({ width: "95%" });
			 $("#institution").trigger("chosen:updated");
		});
    }
});

/*	
$("#country").change(function(event){
	alert('institutions');
	$.get("institutions/"+event.target.value+"", function(res, sta){
		alert('simon');
		
		$("#institution").empty();
		for(i=0;i<res.length;i++){
			$("#institution").append("<option value='"+res[i].id+"'>"+res[i].name+"</option>");
		});
	});
});*/