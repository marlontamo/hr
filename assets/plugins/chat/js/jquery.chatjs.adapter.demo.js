/// <reference path="jquery.chatjs.adapter.ts" />
var DemoAdapterConstants = (function () {
    function DemoAdapterConstants() {
    }
    DemoAdapterConstants.DEFAULT_ROOM_ID = chatroomid;
    return DemoAdapterConstants;
})();

var HRISClientAdapter = (function () {
    function HRISClientAdapter() {
        this.messagesChangedHandlers = [];
        this.typingSignalReceivedHandlers = [];
        this.userListChangedHandlers = [];
    }
    // adds a handler to the messagesChanged event
    HRISClientAdapter.prototype.onMessagesChanged = function (handler, otherUserId) {
        this.messagesChangedHandlers[otherUserId] = handler;
    };

    // adds a handler to the typingSignalReceived event
    HRISClientAdapter.prototype.onTypingSignalReceived = function (handler) {
        this.typingSignalReceivedHandlers.push(handler);
    };

    // adds a handler to the userListChanged event
    HRISClientAdapter.prototype.onUserListChanged = function (handler) {
        this.userListChangedHandlers.push(handler);
    };

    HRISClientAdapter.prototype.triggerMessagesChanged = function (message) {
        for( var i in this.messagesChangedHandlers )
            this.messagesChangedHandlers[i](message);
    };

    HRISClientAdapter.prototype.triggerTypingSignalReceived = function (typingSignal) {
        for (var i = 0; i < this.typingSignalReceivedHandlers.length; i++)
            this.typingSignalReceivedHandlers[i](typingSignal);
    };

    HRISClientAdapter.prototype.triggerUserListChanged = function (userListChangedInfo) {
        for (var i = 0; i < this.userListChangedHandlers.length; i++)
            this.userListChangedHandlers[i](userListChangedInfo);
    };
    return HRISClientAdapter;
})();

var HRISServerAdapter = (function () {
    function HRISServerAdapter(clientAdapter) {
        this.clientAdapter = clientAdapter;

        var user_list = false;
        $.ajax({
            url: base_url + module.get('route') + '/chat_users',
            type:"POST",
            async: false,
            dataType: "json",
            success: function ( response ) {
                user_list = response.users;
            }
        });

        this.users = new Array();
        if( user_list && user_list.length > 0 )
        {
            var tempuser;
            for(var i in user_list)
            {
                tempuser = new ChatUserInfo();
                tempuser.Id = user_list[i].user_id;
                tempuser.RoomId = DemoAdapterConstants.DEFAULT_ROOM_ID;
                tempuser.Name = user_list[i].full_name;
                tempuser.Email = user_list[i].email;
                tempuser.ProfilePictureUrl = root_url + user_list[i].photo;
                tempuser.Status = user_list[i].status;
                this.users.push(tempuser);
            }
        }

        // configuring rooms
        var defaultRoom = new ChatRoomInfo();
        defaultRoom.Id = 1;
        defaultRoom.Name = "Default Room";
        defaultRoom.UsersOnline = this.users.length;

        this.rooms = new Array();
        this.rooms.push(defaultRoom);

        // configuring client to return every event to me
        this.clientAdapter.onMessagesChanged(function (message) {
            return function () {
            };
        });
    }
    HRISServerAdapter.prototype.sendMessage = function (roomId, conversationId, otherUserId, messageText, clientGuid, done) {
        var _this = this;
        console.log("DemoServerAdapter: sendMessage");
        
        // we have to send the current message to the current user first
        // in chatjs, when you send a message to someone, the same message bounces back to the user
        // just so that all browser windows are synchronized
        var bounceMessage = new ChatMessageInfo();
        bounceMessage.UserFromId = user_id; // It will from our user
        bounceMessage.UserToId = otherUserId; //recipient
        bounceMessage.RoomId = roomId;
        bounceMessage.ConversationId = conversationId;
        bounceMessage.Message = messageText;
        bounceMessage.ClientGuid = clientGuid;

        setTimeout(function () {
            _this.clientAdapter.triggerMessagesChanged(bounceMessage);
        }, 300);

        _this.getUserInfo(otherUserId, function(userinfo){
            if(userinfo.Status != "offline")
            {
                var args = {
                    broadcaster: user_id, 
                    notify: false, 
                    roomId: roomId,
                    conversationId: conversationId,
                    otherUserId: otherUserId,
                    messageText: messageText,
                    clientGuid: clientGuid,
                    done: done
                };
                socket.emit('get_push_data', {channel: 'recieve_pm_'+otherUserId, args: args});
            }

            $.ajax({
                url: base_url + module.get('route') + '/send_pm',
                type:"POST",
                async: false,
                dataType: "json",
                data: {to:otherUserId, message:messageText},
                success: function ( response ) {
                }
            });
        });
    };

    HRISServerAdapter.prototype.sendTypingSignal = function (roomId, conversationId, userToId, done) {
        console.log("DemoServerAdapter: sendTypingSignal");
        var args = {
            broadcaster: user_id, 
            notify: false, 
            roomId: roomId,
            conversationId: conversationId,
            done: done
        };
        socket.emit('get_push_data', {channel: 'typing_pm_'+userToId, args: args});
    };

    HRISServerAdapter.prototype.seenSignal = function (roomId, conversationId, otherUserId, done) {
        console.log("DemoServerAdapter: seenSignal");
        $.ajax({
            url: base_url + module.get('route') + '/seen_pm',
            type:"POST",
            async: false,
            dataType: "json",
            data: {from:otherUserId},
            success: function ( response ) {
            }
        });
    };

    HRISServerAdapter.prototype.getMessageHistory = function (roomId, conversationId, otherUserId, done) {
        console.log("DemoServerAdapter: getMessageHistory");
        var _this = this;
        var pm = false;
        $.ajax({
            url: base_url + module.get('route') + '/get_recent_pm',
            type:"POST",
            async: false,
            dataType: "json",
            data: {from:otherUserId},
            success: function ( response ) {
                pm = response.pm;
                }
        });

        var messages = [];
        if(pm)
        {
             var message;
            for(var i in pm)
            {
                message = new ChatMessageInfo();
                message.UserFromId = pm[i].from;
                message.RoomId = roomId;
                message.ConversationId = conversationId;
                message.Message = pm[i].message;
                message.UserToId = pm[i].to;
                message.timeline = pm[i].timeline;
                messages[i] = message;
            }
        }
        done(messages);
    };

    HRISServerAdapter.prototype.getUserInfo = function (userId, done) {
        console.log("DemoServerAdapter: getUserInfo");
        var user = null;
        for (var i = 0; i < this.users.length; i++) {
            if (this.users[i].Id == userId) {
                user = this.users[i];
                break;
            }
        }
        if (user == null)
            throw "User doesn't exit. User id: " + userId;
        done(user);
    };

    HRISServerAdapter.prototype.getUserList = function (roomId, conversationId, done) {
        console.log("DemoServerAdapter: getUserList");
        if (roomId == DemoAdapterConstants.DEFAULT_ROOM_ID) {
            done(this.users);
            return;
        }
        throw "The given room or conversation is not supported by the demo adapter";
    };

    HRISServerAdapter.prototype.enterRoom = function (roomId, done) {
        console.log("DemoServerAdapter: enterRoom");

        if (roomId != DemoAdapterConstants.DEFAULT_ROOM_ID)
            throw "Only the default room is supported in the demo adapter";

        var userListChangedInfo = new ChatUserListChangedInfo();
        userListChangedInfo.RoomId = DemoAdapterConstants.DEFAULT_ROOM_ID;
        userListChangedInfo.UserList = this.users;

        this.clientAdapter.triggerUserListChanged(userListChangedInfo);
    };

    HRISServerAdapter.prototype.leaveRoom = function (roomId, done) {
        console.log("DemoServerAdapter: leaveRoom");
    };

    // gets the given user from the user list
    HRISServerAdapter.prototype.getUserById = function (userId) {
        for (var i = 0; i < this.users.length; i++) {
            if (this.users[i].Id == userId)
                return this.users[i];
        }
        throw "Could not find the given user";
    };
    return HRISServerAdapter;
})();

var HRISAdapter = (function () {
    function HRISAdapter() {
    }
    // called when the adapter is initialized
    HRISAdapter.prototype.init = function (done) {
        this.client = new HRISClientAdapter();
        this.server = new HRISServerAdapter(this.client);
        done();
    };
    return HRISAdapter;
})();
//# sourceMappingURL=jquery.chatjs.adapter.demo.js.map
