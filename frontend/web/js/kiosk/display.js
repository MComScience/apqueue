$(function () {
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    /* Socket เวลาเรียกคิว ให้แสดงข้อมุลอัตโนมัติ */
    socket.on('request_calling', function (data) {
        console.log(data.qnum);
        Play();
    });
});
function Play() {
    var myPlayer = videojs("vedio-display_html5_api");
    if (myPlayer.paused()) {
        myPlayer.play();
    } else {
        myPlayer.pause();
    }
}


