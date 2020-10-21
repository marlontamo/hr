$(document).ready(function(){
	init_fancybox();
	init_fancyboxPDF();
	$('#discussion_upload-upload_id-fileupload').fileupload({
	    url: base_url + module.get('route') + '/multiple_upload',
	    autoUpload: true,
	}).bind('fileuploadadd', function (e, data) {
		$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
	}).bind('fileuploaddone', function (e, data) {
		$.unblockUI();
		var file = data.result.file;
		if(file.error != undefined && file.error != "")
	    {
	        notify('error', file.error);
	    }
	    else{
	        var cur_val = $('#discussion_upload-upload_id').val();
	    	if( cur_val == '' )
	    		$('#discussion_upload-upload_id').val(file.upload_id);
	    	else
	    		$('#discussion_upload-upload_id').val(cur_val + ',' +file.upload_id);
	    	$('#discussion_upload-upload_id-container ul').append(file.icon);
	    }
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#discussion_upload-upload_id-container .fileupload-delete').stop().live('click', function(event){
		event.preventBubble=true;
		var upload_id = $(this).attr('upload_id');
		$('li.fileupload-delete-'+upload_id).remove();
		var cur_val = $('#discussion_upload-upload_id').val();
		var new_val = new Array();
		new_val_ctr = 0;
		if(cur_val != ""){
			cur_val = cur_val.split(',');
			for(var i in cur_val)
			{
				if( cur_val[i] != upload_id )
				{
					new_val[new_val_ctr] = cur_val[i];
					new_val_ctr++;
				}
			}
		}

		if( new_val_ctr == 0 )
			$('#discussion_upload-upload_id').val( '' );
		else
			$('#discussion_upload-upload_id').val( new_val.join(',') );
	});


	$("#status_message").emojioneArea({
      pickerPosition: "bottom",
      filtersPosition: "bottom",
      shortnames: true,
      autoHideFilters: true
    }); 

	$('form[name="add-post"]').submit(function(e){
		var data = $(this).serialize();
		$.blockUI({ message: loading_message(), 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/add_post',
					type:"POST",
					async: false,
					data: data,
					dataType: "json",
					beforeSend: function(){
					},
					success: function ( response ) {
						handle_ajax_message( response.message );
						//append result
						prepend_post( response.post_id );

						if(response.group_notif != "undefined")
						{
							for(var i in response.group_notif)
								socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}

						$('form[name="add-post"] input[name="post"]').val('');
						$('div.emojionearea-editor').html('');
					}
				});
			}
		});
		$.unblockUI();
		e.preventDefault();
	});

});


var activityTimeout = setTimeout(inActive, 1000*60);

function resetActive(){
    clearTimeout(activityTimeout);
    activityTimeout = setTimeout(inActive, 1000*60);
}

// No activity do something.
function inActive(){
    create_list();
}

// Check for mousemove, could add other events here such as checking for key presses ect.
$(document).bind('mousemove', function(){resetActive()});

function view_post(post_id)
{
    $.ajax({
        url: base_url + module.get('route') + '/view_post',
        type:"POST",
        data: {post_id: post_id},
        dataType: "json",
        async: false,
        success: function ( response ) {
             console.log(response);
            
        /*    $('.likes-'+feed_id).remove();

            if(response.like_str != "")
            {
                $('.comments-'+feed_id).prepend(response.like_str);
            }

            socket.emit('get_push_data', 
                {
                    channel: 'update_feed_like',
                    args: { 
                        broadcaster: user_id,
                        feed_id: feed_id 
                    }
                }
            ); */ 
        }
    });
}

function init_fancybox()
{
    $(document).on("click", "a.fancybox-buttond", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.fancybox({
        	autoSize: false,
        	maxWidth: "80%", // keeps fancybox width in viewport - adjust to your preference
	        fitToView: false, // allows extend fancybox outside viewport 
	        autoCenter: false, // allows scroll fancybox along the body
	        helpers: {
	            overlay: {
	                locked: false // allows scrolling outside fancybox
	            }
	        },
        	margin: [70, 0, 0, 0], // top, right, bottom, left
            scrolling: 'no',
            width: '80%',
            height: 'auto',
            content: '<embed src="'+this.href+'#nameddest=self&page=1&view=FitH,0&zoom=80,0,0" width="100%"/>',
            beforeClose: function() {
                $(".fancybox-inner").unwrap();
            }
        }); //fancybox
        return false;
    });
}

function init_fancyboxPDF()
{
    $(document).on("click", "a.fancybox-buttonPDF", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.fancybox({
            autoSize: false,
        	maxWidth: "80%", // keeps fancybox width in viewport - adjust to your preference
	        fitToView: false, // allows extend fancybox outside viewport 
	        autoCenter: false, // allows scroll fancybox along the body
	        helpers: {
	            overlay: {
	                locked: false // allows scrolling outside fancybox
	            }
	        },
        	margin: [70, 0, 0, 0], // top, right, bottom, left
            scrolling: 'no',
            width: '80%',
            height: '100%',
            content: '<embed src="'+this.href+'#nameddest=self&page=1&view=FitH,0&zoom=80,0,0" height="100%" width="100%"/>',
            beforeClose: function() {
                $(".fancybox-inner").unwrap();
            }
        }); //fancybox
        return false;
    });
}

function init_comment_box()
{
	$('.comment_box').die().stop().on('keypress', function (e) {
	    var comment = this.value;
	    trimmed_comment = comment.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
	    if (e.which == 13 && (trimmed_comment != "")) {
	    	add_comment( $(this).attr('post_id'), trimmed_comment, $(this).attr('comment_id') );
	    	$(this).val('');
	    } else return;
	});
}


function edit_comment( comment_id )
{    
	$('.comment-list-item-'+comment_id).block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/comment_form',
				type:"POST",
				async: false,
				data: {comment_id:comment_id},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('.comment-list-item-'+comment_id+ ' div.message').html(response.comment_form);
					init_comment_box();
					$(".message").find('textarea').each(function() {
		                	var post_id = $(this).attr('post_id');
		                	var comment_id = $(this).attr('comment_id');
		                    $(this).emojioneArea({
		                      pickerPosition: "bottom",
		                      filtersPosition: "bottom",
		                      shortnames: true,
		                      autoHideFilters: true,
		                       events: {
		                           keypress: function(editor, e) {
		                                var comment = this.getText();
		                                trimmed_comment = comment.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		                                if (e.which == 13 && (trimmed_comment != "")) {
		                                    add_comment( post_id, trimmed_comment, comment_id );
		                                    this.setText('');
		                                } //else return; 
		                          }
		                         }
		                    }); 
		                });
				}
			});
		}
	});
	$('.comment-list-item-'+comment_id).unblock();
}

function add_comment( post_id, comment, comment_id )
{
	$('#comment-list-'+post_id).block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/add_comment',
				type:"POST",
				async: false,
				data: {post_id:post_id, comment:comment, comment_id:comment_id},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if (typeof (response.comment) != 'undefined') {
						if (typeof (response.comment_id) != 'undefined'){
	                    	$('.comment-list-item-'+response.comment_id).replaceWith(response.comment);
		                    $('.comment-list-item-'+response.record_id).each(function() {
	                            $(this).html(emojione.shortnameToImage($(this).html()));
	                        }); 
		                }
	                    else
	                    	$(response.comment).insertBefore("#insert_comment-"+post_id).fadeIn();
	                }

	                if(response.group_notif != "undefined")
					{
						for(var i in response.group_notif)
							socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					$(".comment-toggle-").find('span').each(function() {
		                $(this).html(emojione.shortnameToImage($(this).html()));
		            }); 
		            $(".message.com").find('div').each(function() {
		                    $(this).html(emojione.shortnameToImage($(this).html()));
		                });
				}
			});
		}
	});
	$('#comment-list-'+post_id).unblock();
}

function delete_comment( comment_id )
{
    bootbox.confirm("Are you sure you want to delete this comment?", function(confirm) {
        if( confirm )
        {
            _delete_comment( comment_id );
        } 
    });
}

function _delete_comment( comment_id )
{    
    $.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/delete_comment',
				type:"POST",
				async: false,
				data: {comment_id:comment_id},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					$('ul#comment-list-'+response.post_id+' li:not(#insert_comment-'+response.post_id+')').remove();
					$('ul#comment-list-'+response.post_id).prepend(response.comment);
				}
			});
		}
	});
	$.unblockUI();
}

function check_feed(){
	$.ajax({
				url: base_url + module.get('route') + '/get_post_list/'+$('input[name="group_id"].filter').val(),
				type:"GET",
				async: false,
				data: {},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					console.log(response);
				}
			});
}

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.label-success').attr('filter_by');
	var filter_value = $('.list-filter.label-success').attr('filter_value');
	var elem = 0;
	
	$('.feeds-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_post_list/'+$('input[name="group_id"].filter').val(),
		itemSelector: 'li.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
				setTimeout(create_list, 5000);
			}
			else{
				init_comment_box();
			}
			 $(".body").each(function() {
                $(this).html(emojione.unicodeToImage($(this).html())); 
            });

            // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
            $(".body").each(function() {
                $(this).html(emojione.shortnameToImage($(this).html()));
            });

            $(".message.com").find('div').each(function() {
                $(this).html(emojione.shortnameToImage($(this).html()));
            });
            $(".message").find('textarea').each(function() {
            	var post_id = $(this).attr('post_id');
            	var comment_id = $(this).attr('comment_id');
                $(this).emojioneArea({
                  pickerPosition: "bottom",
                  filtersPosition: "bottom",
                  shortnames: true,
                  autoHideFilters: true,
                   events: {
                       keypress: function(editor, e) {
                            var comment = this.getText();
                            trimmed_comment = comment.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                            if (e.which == 13 && (trimmed_comment != "")) {
                                add_comment( post_id, trimmed_comment, comment_id );
                                this.setText('');
                            } //else return; 
                      }
                     }
                }); 
            });

            elem = records;
//elem = $('ul.feeds-list').html();
//console.log(elem);
//setTimeout(create_list, 5000);
		               
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
//setTimeout(create_list, 5000);
	/*setTimeout(function () {
   		//if (old_record > records){
   			create_list();
   		//}
       // $('.record.in').load().fadeIn();

    }, /* Request next message */
        1000*60 /* ..after 1 minute */
   //);
}

function prepend_post( post_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_single_post',
		type:"POST",
		async: false,
		data: {post_id:post_id, group_id:$('input[name="group_id"].filter').val()},
		dataType: "json",
		beforeSend: function(){
		},
		success: function ( response ) {
			handle_ajax_message( response.message );
			$('.feeds-list').prepend(response.post);
			 $(".body").each(function() {
		                    $(this).html(emojione.unicodeToImage($(this).html())); 
		                });

		                // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
		                $(".body").each(function() {
		                    $(this).html(emojione.shortnameToImage($(this).html()));
		                });

		                $(".message.com").find('div').each(function() {
		                    $(this).html(emojione.shortnameToImage($(this).html()));
		                });
		                $(".message").find('textarea').each(function() {

		                    var post_id = $(this).attr('post_id');
		                	var comment_id = $(this).attr('comment_id');
		                    $(this).emojioneArea({
		                      pickerPosition: "bottom",
		                      filtersPosition: "bottom",
		                      shortnames: true,
		                      autoHideFilters: true,
		                       events: {
		                           keypress: function(editor, e) {
		                                var comment = this.getText();
		                                trimmed_comment = comment.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		                                if (e.which == 13 && (trimmed_comment != "")) {
		                                    add_comment( post_id, trimmed_comment, comment_id );
		                                    this.setText('');
		                                } //else return; 
		                          }
		                         }
		                    }); 
		                });
		}
	});	
}

function like_post( post_id, element )
{
    var status = 0;
    if( element.hasClass('btn-default') )
    {
        element.removeClass('btn-default');
        element.addClass('btn-success');
        status = 1;
    }
    else{
        element.removeClass('btn-success');
        element.addClass('btn-default');
    }

    $.ajax({
        url: base_url + module.get('route') + '/like_post',
        type:"POST",
        data: {post_id: post_id, status: status},
        dataType: "json",
        async: false,
        success: function ( response ) {
            $('.likes-'+post_id).remove();

            if(response.like_str != "")
            {
                $('.comments-'+post_id).prepend(response.like_str);
            }

            if(response.group_notif != "undefined")
			{
				for(var i in response.group_notif)
					socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
			} 
        }
    });
}

$(document).on({
	mouseenter: function (e) { 
		e.preventDefault();
		$(this).popover('show'); 
	},
	mouseleave: function (e) { 
		e.preventDefault();
		$(this).popover('hide');
	}
}, ".user_preview");
