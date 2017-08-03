var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;

server.listen(port, function () {
    console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

    socket.on('new_count_message', function (data) {
        io.sockets.emit('new_count_message', {
            new_count_message: data.new_count_message

        });
    });

    socket.on('update_count_message', function (data) {
        io.sockets.emit('update_count_message', {
            update_count_message: data.update_count_message
        });
    });

    socket.on('new_message', function (data) {
        io.sockets.emit('new_message', {
            name: data.name,
            email: data.email,
            subject: data.subject,
            created_at: data.created_at,
            id: data.id
        });
    });

    socket.on('message', function (data) {
        io.sockets.emit('message', {
            name: data.name,
            nickname: data.nickname
        });
    });

    socket.on('request_service', function (data) {
        io.sockets.emit('request_service', {
            request_service: data
        });
    });
    socket.on('request_calling', function (data) {
        io.sockets.emit('request_calling', {
            qnum: data.request_calling,
            service_name: data.service_name
        });
    });
    socket.on('request_delete_hold_recall', function (data) {
        io.sockets.emit('request_delete_hold_recall', {
            qnum: data.request_delete_hold_recall,
            service_name: data.service_name,
            state:data.state
        });
    });

    socket.on('sounds_request', function (data) {
        io.sockets.emit('sounds_request', {
            source: data.source,
        });
    });
});
