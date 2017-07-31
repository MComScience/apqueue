<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\icons\Icon;
use frontend\assets\DatatablesAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\SweetAlertAsset;
use yii\helpers\Url;

DatatablesAsset::register($this);
WaitMeAsset::register($this);
SweetAlertAsset::register($this);
$this->title = Yii::$app->name;

$baseUrl = Url::base(true);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-horizontal',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'options' => ['autocomplete' => 'off'],
                        //'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
        ]);
        ?>
        <?= Html::label('QNumber', 'Queue Number', ['class' => 'col-sm-1 control-label no-padding-right', 'style' => 'font-size: 12pt;']) ?>
        <div class="col-sm-3">
            <?= Html::input('text', 'QNumber', '', ['class' => 'form-control input-lg', 'id' => 'QNumber', 'autofocus' => true, 'placeholder' => 'กรอกหมายเลขคิวหรือบาร์โค้ด', 'required' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= Html::resetButton('Clear',['class' => 'btn btn-danger btn-lg']) ?>
            <?= Html::submitButton(Icon::show('check') . 'Check',['class' => 'btn btn-info btn-lg']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-hourglass-3"></i> <?= Html::encode('Waiting List') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div id="tb-ordercheck-content">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('modal'); ?>
<?php 
$this->registerJs(<<<JS
$(function () {
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    socket.on('request_service', function (data) {
        App.QueryTableOrdercheck();
    });
    App.QueryTableOrdercheck();
});
$('#form-horizontal').on('beforeSubmit', function (e) {
    e.preventDefault();
    App.LoadingClass();
    var dataArray = $(this).serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });
    $('.modal-title').html("รายการคำสั่ง QNum " + dataObj['QNumber']);
    $.ajax({
        type: 'POST',
        url: '$baseUrl/main/default/get-orderlist',
        data: {QNumber: dataObj['QNumber']},
        dataType: "json",
        success: function (result) {
            if (result === 'ไม่มีหมายเลขคิว') {
                swal(result, "", "error");
                $('#wrapper').waitMe('hide');
            } else {
                $("#order-list").html(result);
                $('#wrapper').waitMe('hide');
                $("#modal-orderdetail").modal('show');
            }

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
    return false;
});
App = {
    LoadingClass : function(){
        $('#wrapper').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000', //default #000
            maxSize: '',
            source: 'img.svg',
            fontSize: '20px',
            onClose: function () {
            }
        });
    },
    Save : function(){
        var self = this;
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        var orderids = new Array(); //ID ที่เลือก
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                orderids.push($(this).val());
            }
        });
        var dataArray = $('#orderdetail').serializeArray();
        dataObj = {};
        $(dataArray).each(function (i, field) {
            dataObj[field.name] = field.value;
        });
        $.ajax({
            type: 'POST',
            url: '$baseUrl/main/default/save-orderdetail',
            data: {orderids: orderids, q_ids: dataObj['q_ids']},
            dataType: "json",
            success: function (result) {
                $("#order-list").html('');
                self.QueryTableOrdercheck();
                $('#orderdetail').trigger("reset");
                $('#form-horizontal').trigger("reset");
                $("#modal-orderdetail").modal('hide');
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
            },
        });
    },
    Select : function(e){
        var self = this;
        var QNum = (e.getAttribute("data-id"));
        self.LoadingClass();
        $('.modal-title').html("รายการคำสั่ง QNum " + QNum);
        $.ajax({
            type: 'POST',
            url: '$baseUrl/main/default/get-orderlist',
            data: {QNumber: QNum},
            dataType: "json",
            success: function (result) {
                $("#order-list").html(result);
                $('#wrapper').waitMe('hide');
                $("#modal-orderdetail").modal('show');
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
    },
    QueryTableOrdercheck : function(){
        $.ajax({
            url: '$baseUrl/main/default/table-ordercheck',
            type: 'POST',
            dataType: 'json',
            success: function (result) {
                $('#tb-ordercheck-content').html(result);
                $('#table-ordercheck').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 25,
                    "responsive": true,
                    "language": {
                        "lengthMenu": "_MENU_",
                    },
                });
            },
            error: function (xhr, status, error) {
                swal(error, "", "error");
            }
        });
    },
    Delete: function(e){
        var self = this;
        var q_ids = (e.getAttribute("data-id"));
        var q_num = (e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        swal({
            title: "Delete " + q_num + " ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#74D348",
            confirmButtonText: "Confirm!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '$baseUrl/main/default/delete',
                            type: 'POST',
                            data: {q_ids: q_ids},
                            dataType: 'json',
                            success: function (result) {
                                self.QueryTableOrdercheck();
                                socket.emit('request_delete_hold_recall', {
                                    request_delete_hold_recall: "Delete",
                                    service_name: "ห้องตรวจโรคอายุรกรรม",
                                });
                                swal.close();
                            },
                            error: function (xhr, status, error) {
                                swal(error, "", "error");
                            }
                        });
                    }
                });
    }
};
JS
);
?>
<?php // $this->registerJsFile(Yii::getAlias('@web') . '/js/main/order-check.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
