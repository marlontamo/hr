function after_save( response )
{
	if(response.action == 'insert')
	{
		socket.emit('get_push_data', {channel: 'get_notification', args: { broadcaster: user_id, notify: true }});
	}
}