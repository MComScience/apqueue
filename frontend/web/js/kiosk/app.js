$(function () {
    QueryQNum('AutoLoad', '0');
    QueryQNum('EXRoomAutoload', '0');
    $('#modal-orderdetail').on('hidden.bs.modal', function (e) {
        $('input[type=radio]').iCheck('uncheck');
        $('input[type=checkbox]').iCheck('uncheck');
    });
});
function QService(group, serviceid, title) {
    if (group === 1) {
        swal({
            title: "Confirm?",
            text: title,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#74D348",
            confirmButtonText: "Confirm!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        LoadingClass();
                        QueryQNum('ByConfirm', serviceid);
                    } else {

                    }
                });
    } else {
        $('#modal-orderdetail').modal('show');
        $('.modal-title').html(title);
        $("#service-room-id").val(serviceid);
    }

}
function QueryQNum(Events, serviceid) {
    var base_url = window.location.origin;
    if (Events === 'AutoLoad') {
        $.ajax({
            type: 'POST',
            url: base_url + '/apqueue/kiosk/default/get-qnum',
            data: {Events: 'Autoload'},
            dataType: "json",
            success: function (result) {
                $('#Service1').html('<strong>' + result.qserive1 + ' คิว</strong>');
                $('#Service2').html('<strong>' + result.qserive2 + ' คิว</strong>');
                $('#Service3').html('<strong>' + result.qserive3 + ' คิว</strong>');
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
            },
        });
    } else if (Events === 'ByConfirm') {
        $.ajax({
            type: 'POST',
            url: base_url + '/apqueue/kiosk/default/get-qnum',
            data: {serviceid: serviceid, Events: 'ByConfirm'},
            dataType: "json",
            success: function (result) {
                $('#Service' + serviceid).html('<strong>' + result + ' คิว</strong>');
                $('#wrapper').waitMe('hide');
                swal.close();
                $('#notif_audio')[0].play();
                blinker('Service' + serviceid);
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('#wrapper').waitMe('hide');
            },
        });
    } else if (Events === 'PrintWithoutOrder') {
        $.ajax({
            type: 'POST',
            url: base_url + '/apqueue/kiosk/default/get-qnum',
            data: {serviceid: serviceid, Events: 'PrintWithoutOrder'},
            dataType: "json",
            success: function (result) {
                $('#Service' + serviceid).html(result);
                $('#wrapper').waitMe('hide');
                $('#modal-orderdetail').modal('hide');
                swal.close();
                $('#notif_audio')[0].play();
                blinker('Service' + serviceid);
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('#wrapper').waitMe('hide');
            },
        });
    } else if (Events === 'Print') {
        var orderids = new Array();
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                orderids.push($(this).val());
            }
        });

        if (orderids.length === 0) {
            swal("เลือกช่องบริการ!", "", "warning");
        } else {
            $.ajax({
                type: 'POST',
                url: base_url + '/apqueue/kiosk/default/get-qnum',
                data: {serviceid: serviceid, Events: 'Print'},
                dataType: "json",
                success: function (result) {
                    SaveorderDetail(serviceid, orderids, result.qnum);
                    $('#Service' + serviceid).html(result.result);
                    $('#wrapper').waitMe('hide');
                    $('#modal-orderdetail').modal('hide');
                    swal.close();
                    $('#notif_audio')[0].play();
                    blinker('Service' + serviceid);
                },
                error: function (xhr, status, error) {
                    swal({
                        title: error,
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                    $('#wrapper').waitMe('hide');
                },
            });
        }
    } else if (Events === 'EXRoomAutoload') {
        var myStringArray = [21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
        var arrayLength = myStringArray.length;
        setTimeout(function () {
            for (var i = 0; i < arrayLength; i++) {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/apqueue/kiosk/default/get-qnum',
                    data: {serviceid: myStringArray[i], Events: 'EXRoomAutoload'},
                    dataType: "json",
                    success: function (result) {
                        $('#Service' + result.serviceid).html(result.result);
                    },
                    error: function (xhr, status, error) {
                        swal({
                            title: error,
                            text: "",
                            type: "error",
                            confirmButtonText: "OK"
                        });
                        $('#wrapper').waitMe('hide');
                    },
                });
            }
        }, 1000);
    }
}
function LoadingClass() {
    $('#wrapper').waitMe({
        effect: 'roundBounce', //bounce,rotateplane,stretch,orbit,roundBounce,win8,ios,facebook,rotation,timer,pulse,progressBar,bouncePulse,img
        text: 'Loadding...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000', //default #000
        maxSize: '',
        source: '/apqueue/vendor/waitMe/img.svg',
        fontSize: '27px',
        onClose: function () {
        }
    });
}
function blinker(id) {
    if (document.getElementById(id))
    {
        var varCounter = 0;
        var intervalId = setInterval(function () {
            varCounter++;
            var d = document.getElementById(id);
            d.style.color = (d.style.color == 'yellow' ? 'white' : 'yellow');
            if (varCounter === 10) {
                clearInterval(intervalId);
            }
        }, 500);
    }
}

function PrintWithoutOrder() {
    $('input[type=radio]').iCheck('uncheck');
    var serviceid = $("#service-room-id").val();
    QueryQNum('PrintWithoutOrder', serviceid);
}
function Print() {
    var serviceid = $("#service-room-id").val();
    QueryQNum('Print', serviceid);
}

function SaveorderDetail(serviceid, orderids, qnum) {
    $.post(
            '/apqueue/kiosk/default/save-orderdetail',
            {
                serviceid: serviceid, orderids: orderids, qnum: qnum
            },
            function (data)
            {
                $('#Qservice' + serviceid).html(data);
                $('#myModal').modal('hide');
                $('input[type=checkbox]').iCheck('uncheck');
                $('#order-form').trigger('reset');
            }
    );
}
