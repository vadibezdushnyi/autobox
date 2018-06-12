var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

app.get('/', function(req, res){
  res.send('<h1>listening...</h1>');
});

redis.subscribe('autoboxws', function(err, count) {

});

redis.on("error", function(err) {
    console.log(err);
});

redis.on('message', function(channel, message) {
	var message = JSON.parse(message);
	console.log('new message ', ' emitted to ' + channel + ":" + message.event);
	io.emit(channel + ":" + message.event, message.data);
});

io.on('connection', function(socket){
  console.log('user connected');
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
});

http.listen(3000, '0.0.0.0', function(err, res) {
	console.log('running on *:3000');
});