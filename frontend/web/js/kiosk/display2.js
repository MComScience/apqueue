$(function () {
    QueryTableDisplay("NoData","ห้องตรวจโรค");
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    /* Socket เวลาเรียกคิว ให้แสดงข้อมุลอัตโนมัติ */
    socket.on('request_calling', function (data) {
        QueryTableDisplay(data.qnum, data.service_name);
    });
    socket.on('request_delete_hold_recall', function (data) {
        if (data.qnum === "Hold" || data.qnum === "Delete" || data.qnum === "End") {
            QueryTableDisplay(data.qnum, data.service_name);
        } else {
            blinkercall(data.qnum);
        }
        console.log(data.qnum);
    });
});
function QueryTableDisplay(Qnum, ServiceName) {
    if (ServiceName === "ห้องตรวจโรค") {
        $.ajax({
            url: '/apqueue/kiosk/default/table-display2',
            type: 'POST',
            //data: {data: "NoData"},
            dataType: 'json',
            success: function (result) {
                $('#content-display').html(result);
                if ((Qnum !== "Hold") || (Qnum !== "Delete") || (Qnum !== "End")) {
                    blinkercall(Qnum);
                }
            },
            error: function (xhr, status, error) {
                swal(error, "", "error");
            }
        });
    }

}
function blinkercall(Qnum) {
    if (document.getElementById("Qnum-" + Qnum) && document.getElementById("Counter-" + Qnum))
    {
        var varCounter = 0;
        var intervalId = setInterval(function () {
            varCounter++;
            var q = document.getElementById("Qnum-" + Qnum);
            var c = document.getElementById("Counter-" + Qnum);
            q.style.color = (q.style.color == 'rgb(98, 203, 49)' ? 'white' : 'rgb(98, 203, 49)');
            c.style.color = (c.style.color == 'rgb(98, 203, 49)' ? 'white' : 'rgb(98, 203, 49)');
            if (varCounter === 15) {
                clearInterval(intervalId);
                q.style.color = 'rgb(98, 203, 49)';
                c.style.color = 'rgb(98, 203, 49)';
            }
        }, 500);
    }
}

