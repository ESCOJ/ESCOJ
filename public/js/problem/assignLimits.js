function assignMemoryLimit(){
    if($('#use_multipliers').is(':checked') ){
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#ml').val();
		    var ml_multiplier = $('#ml_multiplier_'+id).val();
	        $('#ml_'+id).val( parseInt(val * ml_multiplier) ) ; 
		});
	}
	else{
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#ml').val();
	        $('#ml_'+id).val(parseInt(val)); 
		});
	}
};

function assignSourceLimit(){

    if($('#use_multipliers').is(':checked') ){
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#sl').val();
		    var sl_multiplier = $('#sl_multiplier_'+id).val();
		    alert('id '+id+' val '+val+' sl_multiplier '+sl_multiplier);
	        $('#sl_'+id).val( parseInt(val * sl_multiplier) ); 
		});
	}
	else{
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#sl').val();
	        $('#sl_'+id).val(parseInt(val)); 
		});
	}
};

function assignTimeLimitPerCase(){
    if($('#use_multipliers').is(':checked') ){
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#tlpc').val();
		    var tlpc_multiplier = $('#tlpc_multiplier_'+id).val();
	        $('#tlpc_'+id).val( parseInt(val * tlpc_multiplier) ); 
		});
	}
	else{
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#tlpc').val();
	        $('#tlpc_'+id).val(parseInt(val)); 
		});
	}
};

function assignTotalTimeLimit(){
    if($('#use_multipliers').is(':checked') ){
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#ttl').val();
		    var ttl_multiplier = $('#ttl_multiplier_'+id).val();
	        $('#ttl_'+id).val( parseInt(val * ttl_multiplier) ); 
		});
	}
	else{
		$('#languages option').each(function() {
		    var id = $(this).text();
		    var val = $('#ttl').val();
	        $('#ttl_'+id).val(parseInt(val)); 
		});
	}
};

function assignAllLimits(){
    if($('#use_multipliers').is(':checked') ){
		$('#languages option').each(function() {

		    var id = $(this).text();
		    
		    //Memory Limit
		    var ml_val = $('#ml').val();
		    var ml_multiplier = $('#ml_multiplier_'+id).val();
	        $('#ml_'+id).val( parseInt(ml_val * ml_multiplier) );
	        //Source Limit
		    var sl_val = $('#sl').val();
		    var sl_multiplier = $('#sl_multiplier_'+id).val();
	        $('#sl_'+id).val( parseInt(sl_val * sl_multiplier) ); 
	        //Time Limit Per Case
		    var tlpc_val = $('#tlpc').val();
		    var tlpc_multiplier = $('#tlpc_multiplier_'+id).val();
	        $('#tlpc_'+id).val( parseInt(tlpc_val * tlpc_multiplier) ); 
	        //Total Time Limit
		    var ttl_val = $('#ttl').val();
		    var ttl_multiplier = $('#ttl_multiplier_'+id).val();
	        $('#ttl_'+id).val( parseInt(ttl_val * ttl_multiplier) );  

		});
	}
	else{
		$('#languages option').each(function() {

		    var id = $(this).text();

	        //Memory Limit
		    var ml_val = $('#ml').val();
	        $('#ml_'+id).val( parseInt(ml_val) );
	        //Source Limit
		    var sl_val = $('#sl').val();
	        $('#sl_'+id).val( parseInt(sl_val) ); 
	        //Time Limit Per Case
		    var tlpc_val = $('#tlpc').val();
	        $('#tlpc_'+id).val( parseInt(tlpc_val) ); 
	        //Total Time Limit
		    var ttl_val = $('#ttl').val();
	        $('#ttl_'+id).val( parseInt(ttl_val) );

		});
	}
};

function assignAllMultipliers(){
	$('#languages option').each(function() {

	    var id = $(this).text();
	    
	    //Memory Limit
	    var ml_val = $('#ml').val();
	    var ml_multiplier = $('#ml_multiplier_'+id).val();
        $('#ml_'+id).val( parseInt(ml_val * ml_multiplier) );
        //Source Limit
	    var sl_val = $('#sl').val();
	    var sl_multiplier = $('#sl_multiplier_'+id).val();
        $('#sl_'+id).val( parseInt(sl_val * sl_multiplier) ); 
        //Time Limit Per Case
	    var tlpc_val = $('#tlpc').val();
	    var tlpc_multiplier = $('#tlpc_multiplier_'+id).val();
        $('#tlpc_'+id).val( parseInt(tlpc_val * tlpc_multiplier) ); 
        //Total Time Limit
	    var ttl_val = $('#ttl').val();
	    var ttl_multiplier = $('#ttl_multiplier_'+id).val();
        $('#ttl_'+id).val( parseInt(ttl_val * ttl_multiplier) );  

	});
};