
	var Calendar = function () {

	    return {
	        //main function to initiate the module
	        init: function () {
	            Calendar.initCalendar();
	        },

	        initCalendar: function () {

	            if (!jQuery().fullCalendar) {
	                return;
	            }

	            var date = new Date();
	            var d = date.getDate();
	            var m = date.getMonth();
	            var y = date.getFullYear();

	            var h = {};
	            if (App.isRTL()) {
	                 if ($('#calendar').parents(".portlet").width() <= 720) {
	                    $('#calendar').addClass("mobile");
	                    h = {
	                        right: 'title, prev, next',
	                        center: '',
	                        right: 'agendaDay, agendaWeek, month, today'
	                    };
	                } else {
	                    $('#calendar').removeClass("mobile");
	                    h = {
	                        right: 'title',
	                        center: '',
	                        left: 'agendaDay, agendaWeek, month, today, prev,next'
	                    };
	                }                
	            } else {
	                 if ($('#calendar').parents(".portlet").width() <= 720) {
	                    $('#calendar').addClass("mobile");
	                    h = {
	                        left: 'title, prev, next',
	                        center: '',
	                        right: 'today,month,agendaWeek,agendaDay'
	                    };
	                } else {
	                    $('#calendar').removeClass("mobile");
	                    h = {
	                        left: 'title',
	                        center: '',
	                        right: 'prev,next,today,month,agendaWeek,agendaDay'
	                    };
	                }
	            }
	           
	            var initDrag = function (el) {
	                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
	                // it doesn't need to have a start or end
	                var eventObject = {
	                    title: $.trim(el.text()) // use the element's text as the event title
	                };
	                // store the Event Object in the DOM element so we can get to it later
	                el.data('eventObject', eventObject);
	                // make the event draggable using jQuery UI
	                el.draggable({
	                    zIndex: 999,
	                    revert: true, // will cause the event to go back to its
	                    revertDuration: 0 //  original position after the drag
	                });
	            }

	            var addEvent = function (title, code, form_id) {
	                title = title.length == 0 ? "Untitled Event" : title;
	                var html = $('<div class="external-event label label-default" data-width="800" data-toggle="modal" name="'+code+'" id="'+form_id+'">' + title + '</div>');
	                jQuery('#event_box').append(html);
	                initDrag(html);
	            }

	            $('#external-events div.external-event').each(function () {
	                initDrag($(this))
	            });

	            $('#event_add').unbind('click').click(function () {
	                var title = $('#event_title').val();
	                addEvent(title);
	            });

	            //predefined events
	            $('#event_box').html("");
	            
	            $('#calendar').fullCalendar('destroy'); // destroy the calendar
	            $('#calendar').fullCalendar({ //re-initialize the calendar
	                header: h,
	                slotMinutes: 15,
	                editable: true,
	                droppable: true, // this allows things to be dropped onto the calendar !!!
	                drop: function (date, allDay) { // this function is called when something is dropped

	                    // retrieve the dropped element's stored Event Object
	                    var originalEventObject = $(this).data('eventObject');
	                    // we need to copy it, so that multiple events don't have a reference to the same object
	                    var copiedEventObject = $.extend({}, originalEventObject);

	                    // assign it the date that was reported
	                    copiedEventObject.start = date;
	                    copiedEventObject.allDay = allDay;
	                    copiedEventObject.className = $(this).attr("data-class");

	                    // render the event on the calendar
	                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
	                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

	                    // is the "remove after drop" checkbox checked?
	                    if ($('#drop-remove').is(':checked')) {
	                        // if so, remove the element from the "Draggable Events" list
	                        $(this).remove();
	                    }

	                    if($(this).hasClass("external-event")) {
							// $.blockUI({ message: loading_message(), 
							// 	onBlock: function(){
									$.ajax({
										url: base_url + module.get('route') + '/edit_forms',
										type:"POST",
										async: false,
										data: 'form_title='+$(this).text()+'&start_date='+Math.round(date.getTime() / 1000)+'&form_code='+$(this).attr('name')+'&form_id='+$(this).attr('id'),
										dataType: "json",
										beforeSend: function(){
											// $('.modal-container').modal('show');
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

											if(message_type == "warning")
											{
												$('.modal-container').modal('hide');
												$('body').modalmanager('removeLoading');
												Calendar.init();
											}else{
												if( typeof(response.edit_forms) != 'undefined' )
												{
													$('.modal-container').html(response.edit_forms);
													$('.modal-container').attr('data-width', '800');
													$('.modal-container').modal();
													$('.make-switch').not(".has-switch")['bootstrapSwitch']();
													// handleSelect2();
													// FormComponents.init();
													// element_format();
													upload_files();												
												}
											}
										}
									});	
							// 	}
							// });
							// $.unblockUI();	
					    }
					    // add all existing drop code here
	                },
	                events: function(start,end, callback) {	                	
	                	start_date = $("#calendar").fullCalendar('getView').visStart;
	                	end_date = $("#calendar").fullCalendar('getView').visEnd;
					    $.getJSON(base_url + module.get('route') +'/get_events',
				        	{
				                // our hypothetical feed requires UNIX timestamps
				                start: Math.round(start_date.getTime() / 1000),
				                end: Math.round(end_date.getTime() / 1000)
				            },
				             function(data){
					        var eventsToShow = [];
					        for(var i=0; i<data.time_calendar_events.length; i++){
					        	if (data.time_calendar_events[i].type != "FORM"){
								    data.time_calendar_events[i].editable = false;
								    // data[i].url = edit_time_forms();
								}
					        	eventsToShow.push(data.time_calendar_events[i]);
					        }
					        callback(eventsToShow);

					        //list down form types
				            //predefined events
				            $('#event_box').html("");
					        var form_types = data.form_types;
					        // console.log(form_types.form);
		                	for(i=0; i < form_types.length; i++){
		                		addEvent(form_types[i].form, form_types[i].form_code, form_types[i].form_id);
		                	}
					    });
					},
					eventClick: function(event) {
						if(event.editable != false){
							// $.blockUI({ message: loading_message(), 
							// 	onBlock: function(){
									$.ajax({
										url: base_url + module.get('route') + '/edit_forms',
										type:"POST",
										async: false,
										data: 'start_date='+Math.round(event._start.getTime() / 1000)+'&form_code='+event.title+'&form_id='+event.form_id+'&forms_id='+event.forms_id,
										dataType: "json",
										beforeSend: function(){
											// $('.modal-container').modal('show');
											$('body').modalmanager('loading');
										},
										success: function ( response ) {
											if( typeof(response.edit_forms) != 'undefined' )
											{
												$('.modal-container').html(response.edit_forms);
												$('.modal-container').attr('data-width', '800');
												$('.modal-container').modal();
												$('.make-switch')['bootstrapSwitch']();
												// FormComponents.init();
												// element_format();
												upload_files();
											}

											handle_ajax_message( response.message );
										}
									});	
							// 	}
							// });
							// $.unblockUI();	
						}else{
						console.log("not clickable");
						}
				    }

	            });

	        }

	    };

	}();

	function save_form( forms, status )
	{
		$.blockUI({ message: saving_message(),
			onBlock: function(){
				forms.submit( function(e){ e.preventDefault(); } );
				var save_url = forms.attr('action');
				var data = forms.find(":not('.dontserializeme')").serialize()
				$.ajax({
					url: save_url,
					type:"POST",
					data: data + "&form_status_id=" + status,
					dataType: "json",
					async: false,
					beforeSend: function(){
						$('form#edit-forms-form').block({ message: '<div>Saving '+$('#forms_title').val()+', please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
					},
					success: function ( response ) {
						$('form#edit-forms-form').unblock();
						
						if( typeof response.forms_id != 'undefiend' )
						{
							$('form#edit-forms-form input[name="forms_id"]').val( response.forms_id );
						}

						if( typeof (response.notified) != 'undefined' )
		                {
		                    for(var i in response.notified)
		                    {
		                        socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
		                    }
		                }

						handle_ajax_message( response.message );

						if(response.saved )
						{
							$('.modal-container').modal('hide');

			  				Calendar.init();
						}
					}
				});
			},
			baseZ: 300000000
		});
		$.unblockUI();
	}

	function back_to_mainform(cancel){
        if(cancel==1){
            get_selected_dates($('#forms_id').val(), $('#form_status_id').val(), $('#date_from').val(), $('#date_to').val());    
        }
	    $('#change_options').hide();
	    $('#main_form').show();
	}

	function get_selected_dates(forms_id, form_status_id, date_from, date_to, form_code){
		$.ajax({
			url: base_url + module.get('route') + '/get_selected_dates',
			type:"POST",
			async: false,
			data: 'forms_id='+forms_id+'&form_status_id='+form_status_id+'&date_from='+date_from+'&date_to='+date_to+'&form_code='+form_code,
			dataType: "json",
			success: function ( response ) {
	  			$('#change_options').html(response.selected_dates);
	  			$('#days').html(response.days);
			}
		});
	}

	function upload_files(){

		$('#time_forms_upload-upload_id-fileupload').fileupload({
		    url: base_url + module.get('route') + '/multiple_upload',
		    autoUpload: true,
		}).bind('fileuploadadd', function (e, data) {
			$.blockUI({ 
				message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
    			baseZ: 20000,
				css: {
					background: 'none',
					border: 'none',		
				    'z-index':'99999'		    	
				}
			});
		}).bind('fileuploaddone', function (e, data) {
			$.unblockUI();
			var file = data.result.file;
			if(file.error != undefined && file.error != "")
			{
				notify('error', file.error);
			}
			else{
				var cur_val = $('#time_forms_upload-upload_id').val();
				if( cur_val == '' )
					$('#time_forms_upload-upload_id').val(file.upload_id);
				else
					$('#time_forms_upload-upload_id').val(cur_val + ',' +file.upload_id);
				$('#time_forms_upload-upload_id-container ul').append(file.icon);
			}
		}).bind('fileuploadfail', function (e, data) {
			$.unblockUI();
			notify('error', data.errorThrown);
		});
		
		$('#time_forms_upload-upload_id-container .fileupload-delete').stop().live('click', function(event){
			event.preventBubble=true;
			var upload_id = $(this).attr('upload_id');
			$('li.fileupload-delete-'+upload_id).remove();
			var cur_val = $('#time_forms_upload-upload_id').val();
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
				$('#time_forms_upload-upload_id').val( '' );
			else
				$('#time_forms_upload-upload_id').val( new_val.join(',') );
		});
	}

	function get_shift_details(date_from, date_to, form_type, type, utype){	
		$.ajax({
			url: base_url + module.get('route') + '/get_shift_details',
			type:"POST",
			async: false,
			data: 'date_from='+date_from+'&date_to='+date_to+'&type='+type+'&form_type='+form_type+'&utype='+utype,
			dataType: "json",
			success: function ( response ) {
				// console.log(response);
				if(form_type == 11){ //DTRP
					$('#date_from').val( response.shift_details.date_from );
					$('#date_to').val( response.shift_details.date_to );
				}

				$('#ut_time_in_out').val( response.shift_details.ut_time_in_out ); //undertime form only
				$('#shift_time_end').html( response.shift_details.shift_time_end );
				$('#shift_time_start').html( response.shift_details.shift_time_start );
				$('#logs_time_out').html( response.shift_details.logs_time_out );
				$('#logs_time_in').html( response.shift_details.logs_time_in );
			}
		});
	}

	function element_format(){		
        $('select.select2me').select2();
		if (jQuery().datepicker) {
		    $('.date-picker').datepicker({
		        rtl: App.isRTL(),
		        autoclose: true
		    });
		    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}
	}

	jQuery(document).ready(function() {       
		// initiate layout and plugins
		// FormComponents.init();
	  	Calendar.init();
	  	UIExtendedModals.init();

		//close modal
		// $('.modal-container').on('hidden.bs.modal', function () {
		// 	Calendar.init();
		// });
		$('.modal-container').on('hidden', function () {
			Calendar.init();
		})
		//close modal
	});    
