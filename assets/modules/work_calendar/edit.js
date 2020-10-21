var Calendar = function () {

    return {

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

            var fl = true;

            var h = {};

            if (App.isRTL()) {

                 if ($('#calendar').parents(".portlet").width() <= 720) {

                    $('#calendar').addClass("mobile");

                    h = {
                        right: 'title, prev, next',
                        center: '',
                        right: 'agendaDay, agendaWeek, month, today'
                    };
            } 
            else{
                
                $('#calendar').removeClass("mobile");

                h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }                
            } 
            else{
                
                if ($('#calendar').parents(".portlet").width() <= 720) {

                    $('#calendar').addClass("mobile");
                    h = {

                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } 

                else {

                    $('#calendar').removeClass("mobile");

                    h = {

                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }
           

            var initDrag = function (el, shift) {

                // create an Event Object 
                // (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {

                	// use the element's text as the event title
                    title: $.trim(el.text()), 
                    shift: shift,
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

            // ADDED id to determine which modal to show on drop
            var addEvent = function (title, id, elem) {
                if (elem == 'event_box'){
                    var type = 'shift';
                }
                else{
                    var type = 'weekly';
                }

                title = title.length == 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default" data-toggle="modal" id="'+ id +'" type='+type+'>' + title + '</div>');
                jQuery('#'+elem+'').append(html);
                initDrag(html, id);
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
            $('#event_box_weekly').html("");
            

            // destroy the calendar
            $('#calendar').fullCalendar('destroy'); 
            
            //re-initialize the calendar
            $('#calendar').fullCalendar({ 

                header: h,
                slotMinutes: 15,
                editable: false,
                // this allows things to be dropped onto the calendar !!!
                droppable: true, 

                // this function is called when something is dropped
                drop: function (date, allDay) { 
                	// retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a 
                    // reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject); 
                    
                    // assign it the date that was reported
                    
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks"
                    // (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {

                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                    if($(this).hasClass("external-event")) { 

                        var type = $(this).attr('type');

                    	var request_data = {start_date: $.fullCalendar.formatDate( date, 'yyyy-MM-dd HH:mm:ss' ), page: 1, shift_id: copiedEventObject.shift, type:type};  
                        
                    	blockMe();

                    	$.ajax({
							url: base_url + module.get('route') + '/get_manager_partners',
							type:"POST",
							async: false,
							data: request_data,
							dataType: "json",
							beforeSend: function(){
							},
							success: function ( response ) {	
							
								if( typeof(response.edit_manage_form) != 'undefined' ){

									$('#calman_form').html(response.edit_manage_form);
									$('#calman_form').attr('data-width', '450');
									$('#calman_form').modal('show');

									if (jQuery().datepicker) {
							            $('.date-picker').datepicker({
							                rtl: App.isRTL(),
							                autoclose: true
							            });

							            // fix bug when inline picker is used in modal
							            $('body').removeClass("modal-open"); 
							        }
								}

								handle_ajax_message( response.message );
							}
						});

						unBlockMe();
				    }
                },
                events: function(start, end, callback) {

                	// get current calendar's start and end date
                	var start = $("#calendar").fullCalendar('getView').visStart;
					var end   = $("#calendar").fullCalendar('getView').visEnd;

                	// important! reset this variable to prevent duplicates
                	CalendarEvents = [];
                	ShiftEvents = [];
                    ShiftWeeklyEvents = [];

                	// re-send ajax request to server with the current calendar values
                	GetCalendarList(start, end);

                	// draw data to calendar
                	callback(CalendarEvents);	

                	if(fl){

	                	for(i=0; i < ShiftEvents.length; i++){
	                		addEvent(ShiftEvents[i].shift, ShiftEvents[i].shift_id,'event_box');
	                	}

                        for(i=0; i < ShiftWeeklyEvents.length; i++){
                            addEvent(ShiftWeeklyEvents[i].calendar, ShiftWeeklyEvents[i].calendar_id,'event_box_weekly');
                        }

	                	fl = false;
	                }
				},

                eventClick: function(calEvent, jsEvent, view) { 

                	if(calEvent.event_type !== 'SCHEDULE') return;

                	blockMe();

				    var full_date 	= new Date(calEvent.start);
					var day 		= full_date.getDate();
					var month 		= full_date.getMonth() + 1;
					var year 		= full_date.getFullYear();
					var date 		= year + "-" + month + "-" + day;
					var shift_id 	= calEvent.shift_id;
					var request_data = {date: date, shift_id: shift_id}; 

				    $.ajax({
						url: base_url + module.get('route') + '/get_assigned_partners',
						type:"POST",
						async: false,
						data: request_data,
						dataType: "json",
						beforeSend: function(){
							//$('#calman_form').modal('show'); 
						},
						success: function ( response ) {	

                        var scrollPos = 0;

                        $('.modal')
                            .on('show.bs.modal', function (){
                                scrollPos = $('body').scrollTop();
                                $('body').css({
                                    overflow: 'hidden',
                                    position: 'fixed',
                                    top : -scrollPos
                                });
                            })
                            .on('hide.bs.modal', function (){
                                $('body').css({
                                    overflow: '',
                                    position: '',
                                    top: ''
                                }).scrollTop(scrollPos);
                            });	 

							$('#calman_view').html();
							$('#calman_view').html(response.edit_assigned_partners);
							$('#calman_view').modal('show');

							jQuery('.tooltips').tooltip();
							jQuery('select.selectM3').select2();
						}
					});	

					unBlockMe();
			    }
            });
        }
    };
}();


var spinnerHTML = '';
var calendarHTML = ';'

var CalendarEvents = [];
var ShiftEvents = [];
var ShiftWeeklyEvents = [];

var save_calendar = function( form ){

	blockMe(); 

	form.submit(function (e) {
	    e.preventDefault();
	});

	var fg_id = form.attr('fg_id');
	var data = form.find(":not('.dontserializeme')").serialize();

	data = data + '&record_id=' + $('#record_id').val(); 
	
	$.ajax({
	    url: base_url + module.get('route') + '/save',
	    type: "POST",
	    data: data,
	    dataType: "json",
	    async: false,
	    success: function (response) { 

	        Calendar.init();

	        for (var i in response.message) {
	            notify(response.message[i].type, response.message[i].message);
	        }
	    }
	});

	$('.modal').modal('hide');
	unBlockMe();
}

var toggle_check_all = function(master){
    var check_all = $(master).attr('checked');

	var checkboxes = $("input[type=checkbox]:not(.toggle)");

	if (checkboxes.size() > 0) {

		checkboxes.each(function () {
		    if (check_all) {
		        $(this).parents(".checker").children('span').addClass('checked');
		        $('.checkboxes').attr('checked', true);
		    } else {
		        $(this).parents(".checker").children('span').removeClass('checked');
		        $('.checkboxes').attr('checked', false);
		    }
		});
	}	                
}

var toggleBatchUpdate = function(){

	if( $(".batch_button").is(':visible') ) {
		$(".batch_button").hide();
		$(".batch_select").show();
	}
	else{
		$(".batch_button").show();
		$(".batch_select").hide();
	}			
}

var customHandleUniform = function () {

    if (!jQuery().uniform) {
        return;
    }

    var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
    if (test.size() > 0) {
        test.each(function () {
            if ($(this).parents(".checker").size() == 0) {
                $(this).show();
                $(this).uniform();
            }
        });
    }
}

var blockMe = function(){

	$.blockUI({
	    message: '<img src="' + base_url + 'assets/img/ajax-loading.gif"><br />Processing, please wait...',
		baseZ: 20000,
	});	

	return false;
}

var unBlockMe = function(){
	setTimeout($.unblockUI, 1000); 
}

var customCloseButtonCallback = function(){
	Calendar.init();
}		    

 // preloading data for the current month as the default
var GetCalendarList = function (startDate, endDate) {

    data = {
        'start_date': $.fullCalendar.formatDate( startDate, 'yyyy-MM-dd HH:mm:ss' ),
        'end_date': $.fullCalendar.formatDate( endDate, 'yyyy-MM-dd HH:mm:ss' )
    };

    $.ajax({
        url: base_url + module.get('route') + '/get_list',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        success: function (data) {

            SetCalendarEvents(data);
        },
    })
    .fail(function (jqXHR, textStatus) {
        console.log("Server returned an invalid response.");
    });
}

var SetCalendarEvents = function (data) {

    var events = [];
    var date = new Date();
    var year = date.getFullYear();

    for (i = 0; i < data.list.length; i++) {

        var eventObject = {
            title: data.list[i].title,
            start: new Date(data.list[i].start * 1000),
            backgroundColor: data.list[i].color,
            shift_id: data.list[i].form_id,
            event_type: data.list[i].type,
        };

        CalendarEvents.push(eventObject);
    }

    // shift events
    for (i = 0; i < data.shift.length; i++) {

        var shiftEventObjects = {
            shift_id: data.shift[i].shift_id,
            shift: data.shift[i].shift,
        };

        ShiftEvents.push(shiftEventObjects);
    }

    // shift weekly events
    var shiftWeeklyEventObjects = {
        calendar_id: 1,
        calendar: 'Weekly Shift Schedule',
    };

    ShiftWeeklyEvents.push(shiftWeeklyEventObjects); 
/*    for (i = 0; i < data.shift_weekly.length; i++) {

        var shiftWeeklyEventObjects = {
            calendar_id: data.shift_weekly[i].calendar_id,
            calendar: data.shift_weekly[i].calendar,
        };

        ShiftWeeklyEvents.push(shiftWeeklyEventObjects);
    }*/

    return;
}

jQuery(document).ready(function() {  
  	Calendar.init();
});