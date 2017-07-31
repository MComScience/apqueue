<?php
use frontend\assets\SweetAlertAsset;
use yii\helpers\Url;
SweetAlertAsset::register($this);
$this->title = 'Sounds';
?>
<h1>Sounds Play</h1>
<?php
$baseUrl = Url::base(true);
$this->registerJs(<<<JS

$(function () {
    GetSound();
});

function SoundPlay(data,i = 0){
    var url;
    var source = data.source;
    var sound = new Howl({
        src: [source[i]],
        autoplay: true,
        loop: false,
        volume: 1.0,
        rate: 1.0,
        onend: function() {
            i++;
            checkSoundPlay(data,i);
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
    var ServiceGroupID = $('#servicegroup :selected').val() || null;
    $.ajax({
        url: '$baseUrl/main/default/get-sound',
        type: 'POST',
        //data: {ServiceGroupID: ServiceGroupID},
        dataType: 'json',
        success: function (result) {
            if(result !== 'No sound!'){
                SoundPlay(result,0);
                //App.ModernBlink("#tr-" + result.qnum);
            }else{
                setTimeout(function(){ GetSound(); }, 1500);
            }
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
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
JS
);?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/howler/dist/howler.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php // $this->registerJsFile(Yii::getAlias('@web') . '/js/main/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.modern-blink.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>