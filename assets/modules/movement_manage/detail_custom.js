$(document).ready(function(){
	$('.approve').click(function(){
        var movement_id     = $(this).data('movement-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var movement_owner  = $(this).data('movement-owner');
        var decission   = $(this).data('decission');
        var comment = $("#comment").val();

        var data = {
            movementid: movement_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            movementownerid: movement_owner,
            comment: comment
        };

        submitDecission(data,'');	
	});

	$('.decline').click(function(){
        var movement_id     = $(this).data('movement-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var movement_owner  = $(this).data('movement-owner');
        var decission   = $(this).data('decission');
        comment = '';

        if (!$("#comment").val()) {
            $("#comment").focus();
            notify("warning", "The Remarks field is required");
            return false;
        } else {
            comment = $("#comment").val();
        }

        var data = {
            movementid: movement_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            movementownerid: movement_owner,
            comment: comment
        };

        submitDecission(data,'');	
	});	
});

function submitDecission(data,view) {
    $.blockUI({ message: saving_message(),
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/movement_decission',
                type: "POST",
                async: false,
                data: data,
                dataType: "json",
                beforeSend: function () {
                    $('.popover-content').block();
                },
                success: function (response) {
                    $('.popover-content').unblock();
                    for (var i in response.message) {
                        notify(response.message[i].type, response.message[i].message);
                    }

                    if (response.action == 'insert') {
                        after_save(response);
                    }
                    if( view == 'index' ){
                        $('.custom_popover').popover('hide');
                    }
                    else{
                        setTimeout(function(){window.location.replace(base_url + module.get('route'))},2000);
                    }
                }
            });
        },
        baseZ: 300000000
    });
    setTimeout(function(){$.unblockUI()},2000);
}

function after_save( response ){    

    //console.log('PERFORMING NODE+SOCKET NOTIFICATION AND LOADING...');
   // console.log('THE RESPONSE DATA: ');
    //console.log(response);
    //console.log('CURRENT USER ID: ');
    //console.log(user_id);
    
    if(response.action == 'insert'){

        if(response.type == 'feed'){ console.log('you have just been FED up!!!... ');


            /*!*
            * The following are socket actions performing
            * dashboard feed notification and post feed
            * broadcast.
            **/

            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
            
            // autoload feeds to their respective recipient/s
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_feed', 
                    args: { 
                        broadcaster: user_id,
                        target: response.target, 
                        notify: false 
                    }
                }
            );
        }
        else if(response.type == 'greetings'){ console.log('loading greetings!!!... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Birthday Greetings notifications
            * broadcast.
            **/
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
        }
        else if(response.type == 'todo'){ console.log('commencing to do... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Todo notification and Todo update 
            * broadcast on/with their respective recipient.
            **/

            // notify recipients with the results of their
            // submitted forms
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );          
        }

    }
}


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