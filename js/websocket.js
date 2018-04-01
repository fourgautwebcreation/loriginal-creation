/*
var socket = io.connect('http://localhost:8083');

socket.on('broadcast', function (message) {
    console.log('ElephantIO broadcast > ' + JSON.stringify(message));
});

socket.on('message', function(obj) {
	console.log(obj);
	if( obj.type == 'error' ){
		$.notify(
			obj.text, 
			"error",
			{
				autoHide: true,
				 autoHideDelay: 5000
			}
		);
	}
		
});
*/