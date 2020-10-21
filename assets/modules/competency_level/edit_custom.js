$(document).ready(function(){

	$('select[name="performance_competency_level[competency_category_id]"]').change(function(){
		update_values( $(this).val() );
	});
	
	$('select[name="performance_competency_level[competency_values_id]"]').change(function(){
		update_libraries( $(this).val() );
	});

});

function update_values( category_id )
{
	if( category_id != "" )
	{
		$('select[name="performance_competency_level[competency_values_id]"]').select2("val","");
		$.ajax({
		    url: base_url + module.get('route') + '/update_values',
		    type: "POST",
		    async: false,
		    data: {category_id: category_id},
		    dataType: "json",
		    beforeSend: function () {
	    		// $("#dept_loader").show();
	    		// $("#department_div").hide();
		    },
		    success: function (response) {
		    	$('select[name="performance_competency_level[competency_values_id]"]').html(response.values);
	    		// $("#dept_loader").hide();
	    		// $("#department_div").show();
		    	// $('select[name="user_id"]').html('');
		    }
		});	
	}	
}

function update_libraries( values_id )
{
	if( values_id != "" )
	{
		$('select[name="performance_competency_level[competency_libraries_id]"]').select2("val","");
		$.ajax({
		    url: base_url + module.get('route') + '/update_libraries',
		    type: "POST",
		    async: false,
		    data: {values_id: values_id},
		    dataType: "json",
		    beforeSend: function () {
	    		// $("#dept_loader").show();
	    		// $("#department_div").hide();
		    },
		    success: function (response) {
		    	$('select[name="performance_competency_level[competency_libraries_id]"]').html(response.libraries);
	    		// $("#dept_loader").hide();
	    		// $("#department_div").show();
		    	// $('select[name="user_id"]').html('');
		    }
		});	
	}	
}