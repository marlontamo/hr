var IdleTimer = function(options)
{
	this.title = 'Session Notification';
	this.message ='Your session is about to expire.';
	this.keepAliveUrl = '/keep-alive';
	this.redirUrl = '/timed-out';
	this.logoutUrl = '/log-out';
	this.warnAfter = warnafter; // 20 minutes
	this.redirAfter = redirafter; // 30 minutes
	
	if ( options )
	{
		for( var i in options )
		{
			eval('this.'+i+' = options.'+i);
		}
	}

	this.dialogTimer = null;
	this.redirTimer = null;
	var $this = this;

	this.keep_alive = function(origin)
	{
		
		$this.reset(origin);
	};

	this.reset = function(origin)
	{
		$.ajax({
			type: 'POST',
			url: $this.keepAliveUrl
		});
		
		if( this.redirTimer != null )
			this.controlRedirTimer('stop', origin);
		
		if( this.dialogTimer != null )
			this.controlDialogTimer('stop', origin);
		
		this.controlDialogTimer('start');
		
		if(origin != "from_another_window")
			socket.emit('get_push_data', {channel: 'keep_alive_'+user_id, args: { broadcaster: user_id, notify: true }});
	};

	this.controlDialogTimer = function(action)
	{
		switch(action) {
			case 'start':
				// After warning period, show dialog and start redirect timer
				$this.dialogTimer = setTimeout($this.showRedirTimer, $this.warnAfter);
				break;
			case 'stop':
				clearTimeout(this.dialogTimer);
				$this.dialogTimer = null;
				break;
		}
	};

	this.showRedirTimer = function(origin)
	{
		if( $('#sessionTimeout-dialog').css('display') != "block" )
		{
			$('#sessionTimeout-dialog').modal('show');
			$('#sessionTimeout-dialog-logout').on('click', function () { window.location = this.logoutUrl; });
			$('#sessionTimeout-dialog').on('hide.bs.modal', $this.keep_alive);	
		}
		if( $this.redirTimer == null ) $this.controlRedirTimer('start', origin);
		if(origin == "from_another_window") socket.emit('get_push_data', {channel: 'show_RedirTimer_'+user_id, args: { broadcaster: user_id, notify: true }});
	};

	this.controlRedirTimer = function(action, origin){
		switch(action) {
			case 'start':
				// Dialog has been shown, if no action taken during redir period, redirect
				$this.redirTimer = setTimeout($this.lockscreen, $this.redirAfter - $this.warnAfter);
				break;
			case 'stop':
				if(origin == "from_another_window")
				{
					$('#sessionTimeout-dialog').modal('hide');	
				}
				else{
					clearTimeout($this.redirTimer);
					$this.redirTimer = null;
				}
				break;
		}
	};

	this.lockscreen = function(origin)
	{
		if(origin != "from_another_window") socket.emit('get_push_data', {channel: 'lockscreen_'+user_id, args: { broadcaster: user_id, notify: true }});
		window.location = $this.redirUrl;
	};

	$('body').append('<div class="modal fade" id="sessionTimeout-dialog"><div><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">'+ this.title +'</h4></div><div class="modal-body">'+ this.message +'</div><div class="modal-footer"><button id="sessionTimeout-dialog-logout" type="button" class="btn btn-default">Logout</button><button id="sessionTimeout-dialog-keepalive" type="button" class="btn btn-primary" data-dismiss="modal">Stay Connected</button></div></div></div></div>');
};