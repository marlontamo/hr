var idletimer = null;
$(document).ready(function(){
	get_notification(false);
	get_group_notification(false);
	get_inbox(false);
	
	$('.group-checkable').stop().live('change', function () {
		var set = $(this).attr("data-set");
		var checked = $(this).is(":checked");
		$(set).each(function () {
			if (checked) {
				$(this).attr("checked", true);
			} else {
				$(this).attr("checked", false);
			}
		});
		$.uniform.update(set);
	});

	$('.modal-container').on('hidden.bs.modal', function (){
		$('.modal-container').html( '' );	
	});

	$('li#header_notification_bar a.dropdown-toggle	').hover(hover_notification);
	$('li#header_gnotification_bar a.dropdown-toggle	').hover(hover_gnotification);
	$('li#header_inbox_bar a.dropdown-toggle	').hover(hover_inbox);

	$('ul.page-sidebar-menu li a, a.active-menu').click(function(){
		var menu_id = $(this).attr('menu_id');
		$.cookie('menu_id', menu_id, {path: '/'});	
	});
	
	var cur_menu = $('li a[menu_id="'+$.cookie('menu_id')+'"]');
	cur_menu.parent('li').addClass('active');
	var parent_menu = cur_menu.attr('parent');
	if( parent_menu != 0 )
	{
		$('li a[menu_id="'+parent_menu+'"]').parent('li').addClass('active');
		$('li a[menu_id="'+parent_menu+'"] span.title').after('<span class="selected"></span>');
		$('li a[menu_id="'+parent_menu+'"] span.arrow').addClass('open');
	}
	
	idletimer = new IdleTimer({
		keepAliveUrl: base_url + module.get('route') + '/sess_keepalive',
		warnAfter: warnafter,
		redirAfter: redirafter,
		redirUrl: base_url + 'screenlock',
		logoutUrl: base_url + 'logout'
	});
	idletimer.controlDialogTimer('start');



});

$(function () {
    $.ajaxSetup({
        error: function (x, status, error) {
            switch( x.status )
            {
            	case 403:
            		notify('warning', lang.alert.sess_exp);
                	setTimeout( 'window.location.href = base_url + "login"', 5000);
                	break;
                case 404:
                	notify('warning', lang.alert.not_found);
                	break;
                default:
                	notify('error', lang.alert.error_occured + ': ' + status + '\n'+lang.alert.error+': ' + error);	
            }
        }
    });
});

function dateDiff(date1,date2,interval) {
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(date1);
    date2 = new Date(date2);
    var timediff = date2 - date1;
    if (isNaN(timediff)) return NaN;
    switch (interval) {
        case "years": return date2.getFullYear() - date1.getFullYear();
        case "months": return (
            ( date2.getFullYear() * 12 + date2.getMonth() )
            -
            ( date1.getFullYear() * 12 + date1.getMonth() )
        );
        case "weeks"  : return Math.abs(Math.floor(timediff / week));
        case "days"   : return Math.abs(Math.floor(timediff / day)); 
        case "hours"  : return Math.abs(Math.floor(timediff / hour)); 
        case "minutes": return Math.abs(Math.floor(timediff / minute));
        case "seconds": return Math.abs(Math.floor(timediff / second));
        default: return undefined;
    }
}

function handle_ajax_message( message )
{
	for( var i in message ){
		if(message[i].message != "") notify(message[i].type, message[i].message);
	}
}

function simple_ajax( url, data, callback )
{
	$.ajax({
		url: url,
		type:"POST",
		async: false,
		data: data,
		dataType: "json",
		success: function ( response ) {
			handle_ajax_message( response.message );
			
			if (typeof(callback) == typeof(Function)) 
				callback( data );
		}
	});	
}

function notify(type, msg, title, callback){
	if (typeof( toastr ) != 'undefined') {
		toastr.options = {
			closeButton: true,
			debug: false,
			showDuration: 1000,
			hideDuration: 1000,
			timeOut:  3000,
			extendedTimeOut: 500,
			showEasing: 'swing',
			hideEasing: 'swing',
			showMethod: 'fadeIn',
			hideMethod: 'fadeOut',
			positionClass: 'toast-bottom-right',
		};

		if( typeof( callback ) == 'function' ){
			toastr.options.onclick = callback;
		}

		var $toast = toastr[type](msg, title);
	}
}

function saving_message()
{
	return '<div>'+lang.common.saving+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />';
}

function loading_blockUI()
{
	$.blockUI({ message: loading_message() });
}

function loading_message()
{
	return '<div>'+lang.common.loading+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />';
}

function processing_blockUI()
{
	$.blockUI({ message: processing_message() });
}

function processing_message()
{
	return '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />'
}

function get_notification( show_toastr )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_notification',
		type:"POST",
		dataType: "json",
		success: function ( response ) {

			if( show_toastr && response.total_unread > 0) notify('info', lang.alert.new_notification);

			if(response.total_unread > 0)
				$('#header_notification_bar span.badge').html( response.total_unread );
			else
				$('#header_notification_bar span.badge').html( '' );
			
			$('#header_notification_bar li#notification-summary').html( '<p>'+lang.alert.you_have+' '+response.total_unread+' '+lang.alert.new_notification_s+'</p>' );
			
			$('#header_notification_bar ul#notification-detail').html('');

			for(var i in response.notification)
			{
				$('#header_notification_bar ul#notification-detail').append( response.notification[i] );	
			}

			/*$('#header_notification_bar ul#notification-detail').find("li").each(function() {
		        $(this).html(emojione.unicodeToImage($(this).html())); 
		    });*/

		    // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
		    /*$('#header_notification_bar ul#notification-detail').find("li").each(function() {
		        $(this).html(emojione.shortnameToImage($(this).html()));
		    });*/
		}
	});
}

function get_group_notification( show_toastr )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_group_notification',
		type:"POST",
		dataType: "json",
		success: function ( response ) {

			if( show_toastr && response.total_unread > 0) notify('info', lang.alert.new_notification);

			if(response.total_unread > 0)
				$('#header_gnotification_bar span.badge').html( response.total_unread );
			else
				$('#header_gnotification_bar span.badge').html( '' );
			
			$('#header_gnotification_bar li#gnotification-summary').html( '<p>'+lang.alert.you_have+' '+response.total_unread+' '+lang.alert.new_notification_s+'</p>' );
			
			$('#header_gnotification_bar ul#gnotification-detail').html('');

			for(var i in response.notification)
			{
				$('#header_gnotification_bar ul#gnotification-detail').append( response.notification[i] );	
			}

			/*$('#header_gnotification_bar ul#gnotification-detail').find("li").each(function() {
		        $(this).html(emojione.unicodeToImage($(this).html())); 
		    });*/

		    // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
		    /*$('#header_gnotification_bar ul#gnotification-detail').find("li").each(function() {
		        $(this).html(emojione.shortnameToImage($(this).html()));
		    });*/
		}
	});
}

function get_inbox( show_toastr )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_inbox',
		type:"POST",
		dataType: "json",
		success: function ( response ) {
			if( show_toastr )
				notify('info', 'You have new message(s).');
			if(response.total_messages > 0)
				$('#header_inbox_bar span.badge').html( response.total_messages );
			else
				$('#header_inbox_bar span.badge').html( '' );
			
			$('#header_inbox_bar li#inbox-summary').html( '<p>'+lang.alert.you_have+' '+response.total_messages+' '+lang.alert.new_message_s+'</p>' );
			
			$('#header_inbox_bar ul#inbox-detail').html('');
			for(var i in response.inbox)
			{
				$('#header_inbox_bar ul#inbox-detail').append( response.inbox[i] );	
			}
		}
	});
}

function hover_notification( event )
{
	event.stopPropagation();
	if( $('#header_notification_bar span.badge').html() != '' )
	{
		$('#header_notification_bar span.badge').html( '' );
		simple_ajax( base_url + module.get('route') + '/unnotify', '');
	}
}

function hover_gnotification( event )
{
	event.stopPropagation();
	if( $('#header_gnotification_bar span.badge').html() != '' )
	{
		$('#header_gnotification_bar span.badge').html( '' );
		simple_ajax( base_url + module.get('route') + '/unnotify_group', '');
	}
}

function hover_inbox( event )
{
	event.stopPropagation();
	if( $('#header_inbox_bar span.badge').html() != '' )
	{
		$('#header_inbox_bar span.badge').html( '' );
		simple_ajax( base_url + module.get('route') + '/uninbox', '');
	}
}

function reset_all_config()
{
	bootbox.confirm(lang.confirm.del_sys_con, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/reset_all_config',
						type:"POST",
						async: false,
						dataType: "json",
						success: function ( response ) {
							$.unblockUI();	
						}
					});
				}
			});
		}
	});
}

function quick_edit( record_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/quick_edit',
				type:"POST",
				async: false,
				data: 'record_id='+record_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();	
}

function quick_add()
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/quick_add',
				type:"POST",
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '800');
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();	
}

function get_feed(target){

	$.ajax({
		url: base_url + module.get('route') + '/get_feed',
		type:"POST",
		data: {feed_id: target},
		async: false,
		dataType: "json",
		success: function ( response ) {

			$(".feeds_container").prepend(response.feed_latest).fadeIn();
		}
	});	
}

function change_password()
{
	bootbox.confirm(lang.confirm.change_pass, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: loading_message(), 
				onBlock: function(){
					$.ajax({
						url: base_url + 'get_password_form',
						type:"POST",
						dataType: "json",
						async: false,
						success: function ( response ) {
							$('.modal-container').attr('data-width', '500');
							$('.modal-container').html(response.password_form);
							$('.modal-container').modal();
							init_password_form();
						}
					});
				}
			});
			$.unblockUI();
		}
	});	
}

function support_box()
{
	$.ajax({
		url:  base_url + 'get_support_box_form',
		type:"POST",
		dataType: "json",
		async: false,
		success: function ( response ) {
			if( typeof(response.support_box_form) != 'undefined' )
			{
				$('.modal-container').attr('data-width', '500');
				$('.modal-container').attr('data-html2canvas-ignore', true);
				$('.modal-container').html(response.support_box_form);
				$('.modal-container').modal();
				
				$(".modal-container").on('shown.bs.modal', function (e) {
	                $('.modal-backdrop').attr('data-html2canvas-ignore', true);
	                $('.modal-scrollable').attr('style', 'z-index: 10051;overflow: auto  !important');
	            });
			}		
		}
	});

}

function remove_commas( nstr ){
	return nstr.replace(/\,/g,'');
}

function add_commas( nstr )
{
	nstr += '';
	x = nstr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while ( rgx.test(x1) ){
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function init_readmore()
{
	$('.read-more .btn').on('click', function(e) {
	    e.preventDefault();
	    var $this = $(this);
	    var $collapse = $this.next();
	    $collapse.removeClass('hidden');
	    $collapse.slideDown('slow');
	    $this.remove();
	});
}

function round(value, decimals) {
    value = Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    return value.toFixed(decimals);
}

function change_business_group( group )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/change_business_group',
				type:"POST",
				dataType: "json",
				data: {group: group},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.success) != 'undefined' && response.success )
					{
						window.location = base_url;
					}
					else{
						$.unblockUI();
					}
				}
			});
		}
	});	
}

function change_lang( lang )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/change_lang',
				type:"POST",
				dataType: "json",
				data: {lang: lang, uri: window.location.href },
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.uri) != 'undefined' && response.uri )
					{
						window.location = response.uri;
					}
					else{
						$.unblockUI();
					}
				}
			});
		}
	});	
}

var destroyCrappyPlugin = function($elem, eventNamespace) {    
    var isInstantiated  = !! $.data($elem.get(0));
    if (isInstantiated) {
        $.removeData($elem.get(0));
        $elem.off(eventNamespace);
        $elem.unbind('.' + eventNamespace);
    }
};