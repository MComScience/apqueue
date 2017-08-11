<?php
use yii\helpers\Html;
use common\helpers\Tables;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use yii\helpers\Url;

use frontend\assets\SweetAlertAsset;
SweetAlertAsset::register($this);
$this->title = 'Sounds';
?>
<div class="row">
    <div class="col-md-8">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                 <h3 class="text-danger">เปิดหน้านี้ทิ้งไว้ให้เสียงเรียกทำงาน</h3>
            </div>
            <div class="panel-body">
                <?php $table = Tables::begin(['options' => ['class' => 'table table-striped table-condensed']]); ?>
                    <?= $table->thead([],[
                        ['label' => 'คิวที่กำลังเรียก','options' => ['style' => 'font-size:16pt;']],
                        ['label' => '#','options' => ['style' => 'font-size:16pt;']],
                    ]) ?>
                    <?= $table->beginBody(['id' => 'content-body']) ?>
                        <?= Html::tag('td','<span id="q-current">-</span>',['style' => 'font-size:16pt;']) ?>
                        <?= Html::tag('td','<i class="pe-7s-volume1"></i>',['style' => 'font-size:16pt;']) ?>
                    <?= $table->endBody() ?>
                <?php Tables::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                Sounds Settings
            </div>
            <div class="panel-body">
                <p>
                <?php
                echo Select2::widget([
                    'name' => 'ServiceGroup',
                    'id' => 'servicegroup',
                    'size' => Select2::LARGE,
                    'data' => ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroupid', 'servicegroup_name'),
                    'options' => [
                        'placeholder' => 'Select Service...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                คิวที่เรียกไปแล้ว
            </div>
            <div class="panel-body">
                <?php $table = Tables::begin(['options' => ['class' => 'table table-striped table-condensed']]); ?>
                    <?= $table->thead([],[
                        ['label' => 'คิวที่เรียกไปแล้ว','options' => ['style' => 'font-size:16pt;']],
                    ]) ?>
                    <?= $table->beginBody(['id' => 'body-called']) ?>
                    <?= $table->endBody() ?>
                <?php Tables::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$baseUrl = Url::base(true);
$this->registerJs(<<<JS

$(function () {
    GetSound();
});

function SoundPlay(data,i = 0,qnum = []){
    var url;
    var source = data.source;
    var sound = new Howl({
        src: [source[i]],
        autoplay: true,
        loop: false,
        volume: 1.0,
        rate: 1.0,
        onend: function() {
            /*var substr = source[i].substr(24, 27).toString();
            if($.inArray(substr, [ "Number.wav", "Service.wav", "Sir.wav"]) === -1){
                qnum.push(substr);
                console.log(qnum);
            }*/
            i++;
            checkSoundPlay(data,i);
        },
        onloaderror: function(){
            swal("เกิดข้อผิดพลาดในการเรียกเสียง", "", "error");
        }
    });
}
function checkSoundPlay(data,i){
    if(data.source.length === i){
        UpdateStatusCall(data.caller_ids);
    }else{
        SoundPlay(data,i);
    }
}
function GetSound(){
    var servicegroup = $('#servicegroup :selected').val() || null;
    $.ajax({
        url: '$baseUrl/main/default/get-sound',
        type: 'POST',
        data: {servicegroup: servicegroup},
        dataType: 'json',
        success: function (result) {
            if(result !== 'No sound!'){
                if($('#servicegroup').find("option:selected").text() === String(result.servicegroup)){
                    $('#q-current').html(result.qnum);
                    $('#body-called').prepend('<tr><td>'+ result.qnum +'</td></tr>')
                    var socket = io.connect('http://' + window.location.hostname + ':3000');
                    socket.emit('sounds_request', {
                        source: result,
                    });
                    SoundPlay(result,0);
                }else{
                    setTimeout(function(){ GetSound(); }, 1500);
                }
                //App.ModernBlink("#tr-" + result.qnum);
            }else{
                setTimeout(function(){ GetSound(); }, 1500);
            }
            swal.close();
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
            setTimeout(function(){ GetSound(); }, 1500);
        }
    });
}

function UpdateStatusCall(caller_ids){
    $.ajax({
        url: '$baseUrl/main/default/update-status-call',
        type: 'POST',
        data: {caller_ids: caller_ids},
        dataType: 'json',
        success: function (result) {
            if(result === 'Update Success!'){
                GetSound();
            }else{
                swal(result, "", "error");
            }
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
$(function () {
    if (localStorage.getItem("soundservice") === 'ห้องตรวจโรคอายุรกรรม') {
        $("#servicegroup").val(2).trigger("change");
    } else if (localStorage.getItem("soundservice") === 'คัดกรองผู้ป่วยนอก') {
        //localStorage.setItem("servicegroup", "คัดกรองผู้ป่วยนอก");
        $("#servicegroup").val(1).trigger("change");
    }else{
        swal("กรุณาตั้งค่า Service", "เซ็ตได้ 1 browser ต่อ 1 Service เท่านั้น!", "warning");
    }
});
/* SetLocalStorage On Change ServiceGroup */
$('#servicegroup').on('change', function (e) {
    var ServiceGroupName = $(this).find("option:selected").text() || null;
    if (ServiceGroupName !== "Select Service...") {
        if (localStorage.getItem("soundservice") === ServiceGroupName) {
            localStorage.setItem("soundservice", ServiceGroupName);
        } else {
            localStorage.setItem("soundservice", ServiceGroupName);
        }
    } else {
        localStorage.removeItem("soundservice");
    }

});
JS
);?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/howler/dist/howler.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php // $this->registerJsFile(Yii::getAlias('@web') . '/js/main/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.modern-blink.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>