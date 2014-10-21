
// Setting up EXPRESS
var gameport = process.env.PORT || 4004,
    io       = require('socket.io'),
    express  = require('express'),
    UUID     = require('node-uuid'),
    verbose  = false,
    app      = express.createServer();

app.listen(gameport);

// check working
console.log( '\t :: Express :: Listen on port ' + gameport); 

// forward path to index.html
app.get( '/', function(req, res) {
	res.sendfile( __dirname + 'index.html');
});

// Handler. Listens to requests from root
app.get('/*', function(req, res, next) {

	//This is the cur file requested
	var file = req.params[0];

	// debug tool, track which files requested. 
	if(verbose) console.log('\t :: Express :: file requested : ' + file);

	//send the file to client
	res.sendfile( __dirname + '/' + file);
});

/* Set up socket.io */
var sio = io.listen(app);

// setup socket.io connection setting
sio.configure( function() {

	sio.set('log level', 0);

	sio.set('authorization', function(handshakeData, callback) {
		callback(null, true);
	});

});

// This is called when a client connects. Issues a unique UUID for connected player list. 
sio.sockets.on( 'connection', function( client ) {

	// Generate UUID, store at the socket
	client.userid = UUID();

	// Alert connection for player, show UUID
	client.emit('onconnected', {id: client.userid} );

	console.log('\t socket.io:: player ' + client.userid + ' connected');

	client.on('disconnect', function() {

		console.log('\t socket.io:: client disconnected ' + client.userid);
	});

});