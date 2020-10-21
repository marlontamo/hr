$(document).ready(function(e) { 
	$('.filter-type').click(function(){
		$('.filter-type').removeClass('label-success');
		$('.filter-type').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list2();
	});
	$('.filter-due').click(function(){
		$('.filter-due').removeClass('label-success');
		$('.filter-due').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list2();
	});
});

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.active').attr('filter_by');
	var filter_value = $('.list-filter.active').attr('filter_value');
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list',
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
			}

			initPopup();
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}

function create_list2()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = {
		type_id: $('.filter-type.label-success').attr('filter_value'),
		due_to_id: $('.filter-due.label-success').attr('filter_value'),
	}
	var filter_value = $('.list-filter.active').attr('filter_value');
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list',
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
			}
			initPopup();
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}

function initPopup(){
    var showTodoQuickView = function (e) {
        e.preventDefault();
        $('.custom_popover').not(this).popover('hide')
        $(this).popover('show');
        //$(this).popover('toggle');
    }
    , hideTodoQuickView = function (e) {
        e.preventDefault();
        $(this).popover('hide');
    };

    $('.custom_popover').on('click', function(e){    	
        e.preventDefault();
    });

    $('.custom_popover')
        .popover({ 
            trigger: 'manual', 
            title: '', 
            content: '', 
            html:true })
        .on('click', showTodoQuickView)
        .parent()
        .delegate('button.close-pop', 'click', function(e) {
            e.preventDefault();
            $('.custom_popover').popover('hide');
        })
        .delegate('button.approve-pop', 'click', function(e) {
            e.preventDefault();
            //$('.custom_popover').popover('hide');
            //console.log('now update movement set selected item to approved!');

            
            var movement_id     = $(this).data('movement-id');
            var user_id     = $(this).data('user-id');
            var user_name   = $(this).data('user-name');
            var movement_owner  = $(this).data('movement-owner');
            var decission   = $(this).data('decission');

            comment = $("#comment-" + movement_id).val();

            var data = {
                movementid: movement_id,
                userid: user_id,
                username: user_name,
                decission: decission,
                movementownerid: movement_owner,
                comment: comment
            };

            submitDecission(data,'index');


        })
        .delegate('button.decline-pop', 'click', function(e) {
            e.preventDefault();

            var movement_id     = $(this).data('movement-id');
            var user_id     = $(this).data('user-id');
            var user_name   = $(this).data('user-name');
            var movement_owner  = $(this).data('movement-owner');
            var decission   = $(this).data('decission');
            var comment = '';

            if (!$("#comment-" + movement_id).val()) {
                $("#comment-" + movement_id).focus();
                notify("warning", "The Remarks field is required");
                return false;
            } else {
                comment = $("#comment-" + movement_id).val();
            }

            var data = {
                movementid: movement_id,
                userid: user_id,
                username: user_name,
                decission: decission,
                movementownerid: movement_owner,
                comment: comment
            };

            submitDecission(data,'index');
        });
}

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

                        $('#record-list').empty();

                        $('#record-list').infiniteScroll({
                            dataPath: base_url + module.get('route') + '/get_list',
                            itemSelector: 'tr.record',
                            onDataLoading: function(){ 
                                $("#loader").show();
                            },
                            onDataLoaded: function(x, y, z){ 
                                $("#loader").hide();
                                initPopup();
                            },
                            onDataError: function(){ 
                                return;
                            },
                            search: $('input[name="list-search"]').val()
                        });
                        $('.modal-container').modal('hide');
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