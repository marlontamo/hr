var app = require('http').createServer()
, io = require('../../node_modules/socket.io').listen(app, { log: true })
, fs = require('fs');

app.listen(8081);

io.sockets.on('connection', function (socket) {
	socket.on('get_push_data', function(data){
		socket.broadcast.emit(data.channel, data.args); //other listeners
		//socket.emit(data.channel, data.args); //emit to self, no need to notify user since user instantiated the event, uncomment for test purposes
	});
});