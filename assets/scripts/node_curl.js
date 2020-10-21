var args = process.argv.slice(2);
console.log( args );
var socket = require('../../node_modules/socket.io-client').connect('http://localhost:8081');
socket.emit('get_push_data', {channel: args[0], args: args[1]});
socket.on ('got_it', function (data) {
	socket.disconnect();
	process.exit();
});