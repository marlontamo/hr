var ChatBox;
function init_chat(){
	ChatBox = $.chat({
	    // your user information
	    userId: user_id,
	    // id of the room. The friends list is based on the room Id
	    roomId: chatroomid,
	    // text displayed when the other user is typing
	    typingText: ' is typing...',
	    // title for the rooms window
	    roomsTitleText: 'Rooms',
	    // title for the 'available rooms' rab
	    availableRoomsText: 'Available rooms',
	    // text displayed when there's no other users in the room
	    emptyRoomText: "There's no one around here. You can still open a session in another browser and chat with yourself :)",
	    // the adapter you are using
	    chatJsContentPath: '/basics/chatjs/',
	    adapter: new HRISAdapter()
	});

	var users = ChatBox.options.adapter.server.users;
	socket.emit('get_push_data', {channel: 'chat_userlist_change_'+chatroomid, args: { broadcaster: user_id, notify: false, users:users} });

	var options = {
	  valueNames: ['content']
	};

	var userList = new List('chat-user-list', options);
}

socket.on('recieve_pm_'+user_id, function (data) {
	if( !ChatBox.findPmWindowByOtherUserId(data.broadcaster) )
	{
		ChatBox.createPmWindow(data.broadcaster, true, true);
	}
	var pm = new ChatMessageInfo();
	pm.UserFromId = data.broadcaster;
    pm.RoomId = data.roomId;
    pm.ConversationId = data.conversationId;
    pm.Message = data.messageText;
    pm.UserToId = user_id;
    ChatBox.options.adapter.server.clientAdapter.triggerMessagesChanged(pm);
});

socket.on('typing_pm_'+user_id, function (data) {
	if( ChatBox.findPmWindowByOtherUserId(data.broadcaster) )
	{
		ChatBox.options.adapter.server.getUserInfo(data.broadcaster, function(userinfo){
			var ts = new ChatTypingSignalInfo();
	        ts.ConversationId = data.conversationId;
	        ts.RoomId = data.roomId;
	        ts.UserFrom = userinfo;
			ts.UserToId = user_id;
		    ChatBox.options.adapter.server.clientAdapter.triggerTypingSignalReceived(ts);
		});
	}
});

socket.on('chat_userlist_change_'+chatroomid, function (data) {
	var userListChangedInfo = new ChatUserListChangedInfo();
    userListChangedInfo.RoomId = chatroomid;
    userListChangedInfo.UserList = data.users;
    ChatBox.options.adapter.server.clientAdapter.triggerUserListChanged(userListChangedInfo);
    console.log('user change')
});


function open_chat( from )
{
	var existingPmWindow = ChatBox.findPmWindowByOtherUserId(from);
    if (existingPmWindow)
        existingPmWindow.focus();
    else
        ChatBox.createPmWindow(from, true, true);
}

$(document).ready(function(){
	init_chat();
	var chat_window = $("#chat-user-list").parent();
	var window_title = chat_window.find('.chat-window-title');
	window_title.find('.text').next().addClass('online');
	if(chat_window.hasClass('minimized')){
			window_title.find('.text').before('<div class="pull-right" id="chat-up"><i class="fa fa-angle-up"></i></div>');
		}else{
			window_title.find('.text').before('<div class="pull-right" id="chat-down"><i class="fa fa-angle-down"></i></div>');
		}

	chat_window.click(function() {
		window_title.find('#chat-up').remove();
		window_title.find('#chat-down').remove();
		if(chat_window.hasClass('minimized')){
			window_title.find('#chat-up').remove();
			window_title.find('.text').before('<div class="pull-right" id="chat-up"><i class="fa fa-angle-up"></i></div>');
		}else{
			window_title.find('#chat-down').remove();
			window_title.find('.text').before('<div class="pull-right" id="chat-down"><i class="fa fa-angle-down"></i></div>');
		}
	});
});