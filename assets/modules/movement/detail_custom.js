function display_movement_details(type_id, action_id){	
	if(type_id > 0){
		var data = {
			type_id: type_id,
			action_id: action_id
		};
	}else{		
		var data = {
			type_id: $('#type_id').val(),
			type_name: $('#type_id option:selected').text(),
			action_id: 0
		}
	}

	if(data.type_id > 0){
		$.ajax({
			url: base_url + module.get('route') + '/display_action_movement_details',
			type:"POST",
			async: false,
			data: data,
			dataType: "json",
			beforeSend: function(){
						$('body').modalmanager('loading');
					},
					success: function ( response ) {

						for( var i in response.message )
						{
							if(response.message[i].message != "")
							{
								var message_type = response.message[i].type;
								notify(response.message[i].type, response.message[i].message);
							}
						}

						if( typeof(response.add_movement) != 'undefined' )
						{	
							$('.modal-container-action').html(response.add_movement);
							$('.move_action_modal').append(response.type_of_movement);	
							$('.modal-container-action').modal('show');									// FormComponents.init();
						}

					}
			});	
	}else{
		notify('warning', 'Please select a movement Type.');
	}
}