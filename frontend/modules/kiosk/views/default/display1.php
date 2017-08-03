<?php

use frontend\assets\SweetAlertAsset;
use yii\helpers\Url;

$baseUrl = Url::base(true);
SweetAlertAsset::register($this);
$this->title = 'Display';
?>
<style type="text/css">
    .normalheader {
        display: none;
    }
    .table-responsive{
        border: 0px;
    }
    th {
        width: 100%;
    }
    th p {
        text-align: center;
        font-size: <?= $model['font_size'] ?>;
        color: <?= $model['font_color'] ?>;
        background-color: <?= $model['header_color'] ?>;
        border-radius: 15px;
        border: 5px solid white;
        padding: 5px;
    }
    td {

    }
    td p {
        text-align: center;
        font-size: <?= $model['font_size'] ?>;
        color: <?= $model['font_color'] ?>;
        background-color: <?= $model['column_color'] ?>;
        border-radius: 15px;
        border: 5px solid white;
        padding: 5px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <div class="panel-body" style="background-color: <?= $model['bg_color'] ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="content-display">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="border: 0px;padding:0px;width: auto;">
                                    <p style="font-size: 30pt;color: white;border-radius: 15px;border: 5px solid white;padding: 5px;text-align: center;">
                                        <?= $model['qhold_label'] ?>
                                    </p>
                                </td>
                                <td style="border: 0px;padding:0px;width: 50%;">
                                    <marquee direction="left"><span style="font-size: 40pt;color: yellow;vertical-align: middle;font-weight: bold;"><text id="marquee"></text></span></marquee>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$js = <<< JS
$(function () {
        // setInterval(function(){ 
        //     QueryTableDisplay("NoData", 'คัดกรองผู้ป่วยนอก', 'not-sounds');
        // }, 3000);
//    if((localStorage.getItem("display") === null) || (localStorage.getItem("display") === 'การเงินผู้ป่วยนอก')){
//        localStorage.setItem("display", 'ห้องจ่ายยาผู้ป่วยนอก');
//    }
    //getHoldQ();
    QueryTableDisplay('คัดกรองผู้ป่วยนอก');
    getHoldQ();

    var socket = io('http://' + window.location.hostname + ':3000');

    /* Socket เวลาเรียกคิว ให้แสดงข้อมุลอัตโนมัติ */
    /*socket.on('request_calling', function (data) {
     QueryTableDisplay(data.qnum, data.service_name,data.sounds);
     });*/
    socket.on('sounds_request', function (data) {
        var result = data.source;
        if(result.servicegroup === "คัดกรองผู้ป่วยนอก"){
           QueryTableDisplay('คัดกรองผู้ป่วยนอก',result); 
        }
    });

    socket.on('request_delete_hold_recall', function (data) {

        if (data.state === "Hold" || data.state === "Delete" || data.state === "End") {
            //QueryEmptyTr(data.q_num);
            //QueryTableDisplay(data.state, 'ห้องจ่ายยาผู้ป่วยนอก', 'not-sounds');
            getHoldQ();
            QueryTableDisplay('คัดกรองผู้ป่วยนอก'); 
        } else {
            //QueryTableDisplay(data.qnum, data.service_name,data.sounds);
        }
    });

    //$("#display-select2").val(localStorage.getItem("display")).trigger("change");
    /*
     socket.on('display_state', function (data) {
     if( ($('#display-select2 :selected').text() === data.display_name) && (data.state_display === true)){
     $('div.set-display').css('display', 'block');
     }else if( ($('#display-select2 :selected').text() === data.display_name) && (data.state_display === false)){
     $('div.set-display').css('display', 'none');
     }
     });*/

    socket.on('apply_display', function (data) {
        if(data.display_name === 'คัดกรองผู้ป่วยนอก'){
            location.reload();
        }
        //QueryTableDisplay("NoData", 'ห้องจ่ายยาผู้ป่วยนอก', 'not-sounds');
    });

    socket.on('on_blinkcall', function (data) {
        if ((data.service_name === 'คัดกรองผู้ป่วยนอก')) {
            //QueryTableDisplay(data.qnum, 'ห้องจ่ายยาผู้ป่วยนอก', 'not-sounds');
            //QueryTrDisplay(data.qnum);
            getHoldQ();
        }
    });

});

function QueryTableDisplay(ServiceName,data = null) {
    $.ajax({
        url: '$baseUrl/kiosk/default/table-display',
        type: 'POST',
        data: {ServiceName: ServiceName, data: data},
        dataType: 'json',
        success: function (result) {
            $('#content-display').html(result.table);
            if(data !== null){
                ModernBlink(data.qnum);
            }
            // if ((Qnum !== "Hold") || (Qnum !== "Delete") || (Qnum !== "End")) {
            //     
            // }
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
function QueryTrDisplay(Qnum) {
    var rowCount = $('#table-display tr').length;
    var td = $("#tr-" + Qnum).html();
    $.ajax({
        url: '$baseUrl/kiosk/default/get-tr-display',
        type: 'POST',
        data: {ServiceName: "คัดกรองผู้ป่วยนอก", q_num: Qnum},
        dataType: 'json',
        success: function (result) {
            if(rowCount === 5){
                if (td === undefined) {
                    $('#table-display tr:last').remove();
                }
                $("#tr-" + Qnum).remove();
                $("#tbody-tabledisplay").prepend(result.tr);
            }else{
                
            }
            ModernBlink(Qnum);
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
function QueryEmptyTr(Qnum) {
    var rowCount = $('#table-display tr').length;
    var td = $("#tr-" + Qnum).html();
    $.ajax({
        url: '$baseUrl/kiosk/default/get-empty-tr',
        type: 'POST',
        data: {ServiceName: "คัดกรองผู้ป่วยนอก", q_num: Qnum},
        dataType: 'json',
        success: function (result) {
            if(rowCount === 5){
                if (td !== undefined) {
                    $("#tr-" + Qnum).remove();
                    $("#tbody-tabledisplay").append(result.tr);
                }else{
                    
                }
            }else{
                
            }
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
function blinkercall(Qnum, color) {
    if (document.getElementById("Qnum-" + Qnum) && document.getElementById("Counter-" + Qnum))
    {
        var varCounter = 0;
        var intervalId = setInterval(function () {
            varCounter++;
            var q = document.getElementById("Qnum-" + Qnum);
            var c = document.getElementById("Counter-" + Qnum);
            q.style.display = (q.style.display == "block" ? 'none' : "block");
            c.style.display = (c.style.display == "block" ? 'none' : "block");
            if (varCounter === 15) {
                clearInterval(intervalId);
                q.style.display = "block";
                c.style.display = "block";
            }
        }, 500);
    }
}
/* เรียกเสียง */
function PlaySound(sounds, i) {
    /*if (isIE8orlower() == 0) {
     //alert("ระบบเสียงไม่รองรับ InternetExplorer");
     }*/
    if (i == 0) {
        var url_sound = sounds[0][i];
    } else {
        var url_sound = sounds[i][0];
    }
    var sound1 = new Howl({
        urls: [url_sound],
        autoplay: true,
        //loop: true,
        rate: 1,
        volume: 1.0,
        onend: function () {
            i++;
            if (sounds.length === i) {
                i = 0;
                url_sound = sounds[0][0];
                return false;
            }
            PlaySound(sounds, i);
        },
        onloaderror: function () {
            swal("Oops!", "ระบบเรียกเสียงเกิดข้อผิดพลาด!", "error");
        }
    });
}
function ModernBlink(QNum) {
    $('#Qnum-' + QNum + ',#Counter-' + QNum).modernBlink({
        duration: 1000, // Duration specified in milliseconds (integer)
        iterationCount: 7, // Number of times the element should blink ("infinite" or integer)
        auto: true // Whether to start automatically or not (boolean)
    });
}

function getHoldQ() {
    $.ajax({
        url: '$baseUrl/kiosk/default/query-q-hold',
        type: 'POST',
        data: {display_name: 'คัดกรองผู้ป่วยนอก'},
        dataType: 'json',
        success: function (result) {
            result === false ? $('#marquee').html('') : $('#marquee').html(result);
        },
        error: function (xhr, status, error) {
            //console.log(error);
        }
    });
}       
JS;
$this->registerJs($js);
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.modern-blink.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
