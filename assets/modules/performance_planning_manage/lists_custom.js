$(document).ready(function(){

    $(".filter_status").live('click', function(){
        filter_status( $(this), '' )
    });

});

//add score 
function filter_status(filter, add_form){
	var data={
		planning_id : filter.data('planning-id'),
		dept_id : filter.data('dept-id'),
		status_id : filter.data('status-id')
	}
	// console.log(data);return false;
    $.ajax({
        url: base_url + module.get('route') + '/filter_status',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            if( response.filter_status )
            {  
            	$('.users_'+data.planning_id+'_'+data.dept_id).html(response.filter_status);
            }

        }
    }); 
}