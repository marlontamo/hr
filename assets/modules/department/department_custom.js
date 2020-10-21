$(document).ready(function(){


	$('select[name="users_department[immediate_id]"]').live('change',function(){

		get_immediate_position($(this).val());


	});


});


function get_immediate_position(user_id){


	var url = base_url + module.get('route') + '/get_immediate_position';
	var data = 'user_id='+user_id;

	$.ajax({
	    url: url,
	    dataType: 'json',
	    type:"POST",
	    data: data,
	    success: function (response) {

	    	$('input[name="users_department[immediate_position]"]').val(response.position);

	    }
	});



}