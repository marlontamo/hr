var web_protocol = window.location.protocol;

var socket = io.connect(web_protocol+'//'+location.host+':8081');
//notification broadcasted to a channel where everyone listens
socket.on('get_notification', function (data) {
	//do not notify user if user instantiated the event
	if(data.broadcaster != user_id) get_notification(data.notify);
});

//notification to a user specific channel
socket.on('get_user_'+user_id+'_notification', function (data) {
	get_notification(data.notify);
});

//notification to a user specific channel
socket.on('get_group_'+user_id+'_notification', function (data) {
	get_group_notification(data.notify);
});

//new message broadcasted to a channel where everyone listens
socket.on('get_inbox', function (data) {
	//do not notify user if user instantiated the event
	if(data.broadcaster != user_id) get_inbox(data.notify);
});

//notification to a user specific channel
socket.on('get_user_'+user_id+'_inbox', function (data) {
	get_inbox(data.notify);
});

//dashboard feed channel
socket.on('get_feed', function (data) {
	get_feed(data.target);
});

socket.on('get_user_notification', function (data) {

	/*!*************************************************
	*	data: 
	*			broadcaster		- the messenger
	*			notify			- toastr flag
	*			recipient_id	- reciever
	*
	*	user: 	user_id 		- user identification 
	*							  on receiver channel's
	*							  end
	***************************************************/
	try {
        get_user_notification(user_id, data);
    }
    catch(err) {
        // Handle error(s) here
    }
	
});

socket.on('show_RedirTimer_'+user_id, function (data) {
	idletimer.showRedirTimer('from_another_window');
});

socket.on('lockscreen_'+user_id, function (data) {
	idletimer.lockscreen('from_another_window');
});

socket.on('keep_alive_'+user_id, function (data) {
	idletimer.reset('from_another_window');
});