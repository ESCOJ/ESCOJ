$("#country").change(event => {
	$("#institution").empty();
	$.get(`contestant/institutions/${event.target.value}`, function(res){
		res.forEach(element => {
			$("#institution").append(`<option value=${element.id}> ${element.name} </option>`);
		});
	});
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