<?php
use yii\helpers\Url;
$baseUrl = Url::base(true);
?>
<?php
$js = <<< JS
$(function () {
    Kiosk.QueryQNum('AutoLoad', '0');
    Kiosk.QueryQNum('EXRoomAutoload', '0');
    $('#modal-orderdetail').on('hidden.bs.modal', function (e) {
        $('input[type=radio]').iCheck('uncheck');
        $('input[type=checkbox]').iCheck('uncheck');
        $('input[type=checkbox]').checkboxX('reset');
    });
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    socket.on('request_service', function (data) {
        Kiosk.QueryQNum('AutoLoad', '0');
        Kiosk.QueryQNum('EXRoomAutoload', '0');
        $('#notif_audio')[0].play();
    });
    socket.on('request_calling', function (data) {
        Kiosk.QueryQNum('AutoLoad', '0');
        Kiosk.QueryQNum('EXRoomAutoload', '0');
        $('#notif_audio')[0].play();
    });
    socket.on('request_delete_hold_recall', function (data) {
        Kiosk.QueryQNum('AutoLoad', '0');
        Kiosk.QueryQNum('EXRoomAutoload', '0');
    });
});
Kiosk = {
    QService :  function (group, serviceid, title) {
        var self = this;
        if (group === 1) {
            swal({
                title: "Confirm?",
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#74D348',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                }).then(function () {
                    self.LoadingClass();
                    self.QueryQNum('ByConfirm', serviceid);
                }, function (dismiss) {

            });
        } else {
            $('#modal-orderdetail').modal('show');
            $('.modal-title').html(title);
            $("#service-room-id").val(serviceid);
        }
    },
    QueryQNum : function (Events, serviceid) {
        var base_url = '$baseUrl/kiosk/default/get-qnum';
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        var self = this;
        if (Events === 'AutoLoad') {
            $.ajax({
                type: 'POST',
                url: base_url,
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
                url: base_url,
                data: {serviceid: serviceid, Events: 'ByConfirm'},
                dataType: "json",
                success: function (result) {
                    $('#Service' + serviceid).html('<strong>' + result + ' คิว</strong>');
                    $('#wrapper').waitMe('hide');
                    swal.close();
                    $('#notif_audio')[0].play();
                    //self.Blink('#Service'+ serviceid);
                    socket.emit('request_service', {
                        request_service: 1
                    });
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
                url: base_url,
                data: {serviceid: serviceid, Events: 'PrintWithoutOrder'},
                dataType: "json",
                success: function (result) {
                    $('#Service' + serviceid).html(result);
                    $('#wrapper').waitMe('hide');
                    $('#modal-orderdetail').modal('hide');
                    swal.close();
                    $('#notif_audio')[0].play();
                    self.Blink(serviceid);
                    socket.emit('request_service', {
                        request_service: serviceid
                    });
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
                swal("เลือกรายการ!", "", "warning");
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url,
                    data: {serviceid: serviceid, Events: 'Print'},
                    dataType: "json",
                    success: function (result) {
                        self.SaveorderDetail(serviceid, orderids, result.qnum);
                        $('#Service' + serviceid).html(result.result);
                        $('#wrapper').waitMe('hide');
                        $('#modal-orderdetail').modal('hide');
                        swal.close();
                        $('#notif_audio')[0].play();
                        self.Blink(serviceid);
                        socket.emit('request_service', {
                            request_service: serviceid
                        });
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
                        url: base_url,
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
    },
    LoadingClass : function () {
        $('#wrapper').waitMe({
            effect: 'roundBounce', //bounce,rotateplane,stretch,orbit,roundBounce,win8,ios,facebook,rotation,timer,pulse,progressBar,bouncePulse,img
            text: 'Loadding...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000', //default #000
            maxSize: '',
            source: '$baseUrl/vendor/waitMe/img.svg',
            fontSize: '27px',
            onClose: function () {
            }
        });
    },
    blinker : function (id, color) {
        if (document.getElementById(id))
        {
            var varCounter = 0;
            var intervalId = setInterval(function () {
                varCounter++;
                var d = document.getElementById(id);
                d.style.color = (d.style.color == 'white' ? color : 'white');
                if (varCounter === 10) {
                    clearInterval(intervalId);
                }
            }, 500);
        }
    },
    Blink : function(ServiceID) {
        $(ServiceID).modernBlink({
            duration: 1000, // Duration specified in milliseconds (integer)
            iterationCount: 5, // Number of times the element should blink ("infinite" or integer)
            auto: true // Whether to start automatically or not (boolean)
        });
    },
    PrintWithoutOrder : function () {
        var self = this;
        $('input[type=radio]').iCheck('uncheck');
        $('input[type=checkbox]').checkboxX('reset');
        var serviceid = $("#service-room-id").val();
        self.QueryQNum('PrintWithoutOrder', serviceid);
    },
    Print : function () {
        var self = this;
        var serviceid = $("#service-room-id").val();
        self.QueryQNum('Print', serviceid);
    },
    SaveorderDetail : function (serviceid, orderids, qnum) {
        $.post(
                '$baseUrl/kiosk/default/save-orderdetail',
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
};
JS;
$this->registerJs($js);
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.modern-blink.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php // $this->registerJsFile(Yii::getAlias('@web') . '/js/kiosk/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>