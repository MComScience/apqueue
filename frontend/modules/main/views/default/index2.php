<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\main\models\TbCounterservice;
use yii\helpers\Html;
use kartik\icons\Icon;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\DatatablesAsset;
use frontend\assets\ICheckAsset;
use frontend\assets\TourAsset;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use common\themes\homer\bootstrap\Modal;
use kartik\widgets\DepDrop;

ICheckAsset::register($this);
CrudAsset::register($this);
SweetAlertAsset::register($this);
WaitMeAsset::register($this);
DatatablesAsset::register($this);
TourAsset::register($this);

$session = Yii::$app->session;
$selected = null;
$selected_depdop = null;
if ($session->has('selected_id')){
    $selected = $session->get('selected_id');
}
if ($session->has('selected_depdop')){
    $selected_depdop = $session->get('selected_depdop');
}

$this->title = 'เรียกคิว';
?>
<style>
.swal2-modal .swal2-select {
    height: 40px;
    font-size: 14pt;
}
</style>
<audio id="notif_audio">
    <source src="<?= Yii::getAlias('@web').'/sounds/alert.mp3' ?>" type="audio/mpeg">
</audio>

<div class="row">
    <div class="col-xs-12 col-sm-12">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-horizontal',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'options' => ['autocomplete' => 'off'],
                        //'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
        ]);
        ?>
        <div class="form-group">
            <?= Html::label('หน่วยบริการ', 'Service', ['class' => 'col-sm-2 control-label no-padding-right', 'style' => 'font-size: 14pt;']) ?>
            <div class="col-sm-3">
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
                    'value' => $selected
                ]);
                ?>
            </div>
            <?php /*
              <div class="col-sm-1">
              <?php // Html::a(Icon::show('hand-pointer-o', []) . 'Apply', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'Apply(this);']) ?>
              </div> */
            ?>
            <?= Html::label('QNum', 'Queue Number', ['class' => 'col-sm-1 control-label no-padding-right', 'style' => 'font-size: 14pt;']) ?>
            <div class="col-sm-3">
                <?= Html::input('text', 'QNumber', '', ['class' => 'form-control input-lg', 'id' => 'QNumber', 'autofocus' => true, 'placeholder' => 'กรอกหมายเลขคิวหรือบาร์โค้ด', 'required' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= Html::a('Clear', false, ['class' => 'btn btn-danger btn-lg', 'onclick' => 'App.Reset(this);']) ?>
                <?= Html::a('<i class="fa fa-check"></i> ' . 'Call', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'App.SelectCall(this);',]) ?>
                <?= Html::a('Call Select', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'App.CallSelect(this);',]) ?>
                <?php // Html::a('เลือกคิว', ['get-qwaiting'], ['class' => 'btn btn-success btn-lg', 'role'=>'modal-remote']) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-2">
                <?php
                echo DepDrop::widget([
                    'name' => 'DepDrop',
                    'type'=>DepDrop::TYPE_SELECT2,
                    'options'=>['id'=>'sub-servicegroup','placeholder'=>'เลือกช่องบริการหรือห้องตรวจ'],
                    'select2Options'=>['size' => Select2::LARGE,'pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['servicegroup'],
                        'placeholder'=>'เลือกช่องบริการหรือห้องตรวจ...',
                        'url'=>Url::to(['/main/default/sub-servicegroup'])
                    ],
                    'data' => TbCounterservice::getChildServeice($selected),
                    'pluginEvents' => [
                        "change"=>"function(event, id, value, count) { setSessionDepdop($(this).val()); }",
                    ],
                    'value' => $selected_depdop,
                ]);
                ?>
            </div>
        </div>
        <?php /*
          <div class="form-group hide-input1 display-none" style="display: none;">
          <?= Html::label('เลือกช่องบริการ', 'SelectCounter1', ['class' => 'col-sm-2 col-sm-offset-5 control-label no-padding-right', 'style' => 'font-size: 12pt;color:black;','id' => 'Select-Counter1']) ?>
          <div class="col-sm-3">
          <?php
          echo Select2::widget([
          'name' => 'Counter1',
          'id' => 'Counter1',
          'size' => Select2::LARGE,
          'data' => ArrayHelper::map(TbCounterservice::find()->where(['servicegroupid' => 1])->all(), 'counterserviceid', 'counterservice_name'),
          'options' => [
          'placeholder' => 'Select...',
          ],
          'pluginOptions' => [
          'allowClear' => true
          ],
          ]);
          ?>
          </div>
          </div>
          <div class="form-group hide-input2 display-none" style="display: none;">
          <?= Html::label('Select Counter', 'SelectCounter2', ['class' => 'col-sm-2 col-sm-offset-5 control-label no-padding-right', 'style' => 'font-size: 12pt;color:black;','id' => 'Select-Counter2']) ?>
          <div class="col-sm-3">
          <?php
          echo Select2::widget([
          'name' => 'Counter2',
          'id' => 'Counter2',
          'size' => Select2::LARGE,
          'data' => ArrayHelper::map(TbCounterservice::find()->where(['servicegroupid' => 2])->all(), 'counterserviceid', 'counterservice_name'),
          'options' => [
          'placeholder' => 'Select...',
          ],
          'pluginOptions' => [
          'allowClear' => true
          ],
          ]);
          ?>
          </div>
          </div> */ ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-hourglass-3"></i><?= Html::encode('รอเรียกคิว') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div id="tb-waiting-content">
                    <table class="table table-striped"> 
                        <thead>
                            <tr>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('QNum') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Service Name') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="pe-7s-volume1"></i> <?= Html::encode('เรียกคิว') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div id="tb-calling-content">
                    <table class="table table-striped" > 
                        <thead>
                            <tr>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('QNum') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Service Name') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Counter Number') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /-->
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-hand-stop-o"></i><?= Html::encode('พักคิว') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div id="tb-holdlist-content">
                    <table class="table table-striped"> 
                        <thead>
                            <tr>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('QNum') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Service Name') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('ห้องตรวจ') ?></th>
                                <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                                <td style="font-size: 14pt; text-align: center;">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /-->
        <div class="waitingorder display-none" style="display: none" >
            <div class="hpanel hgreen">
                <div class="panel-heading hbuilt" style="font-size: 16pt;">
                    <i class="fa fa-list-alt"></i>
                    <?= Html::encode('คิวรอผลตรวจ') ?>
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="tb-waitingorder-content" >
                        <table class="table table-striped" > 
                            <thead>
                                <tr>
                                    <th style="font-size: 10pt; text-align: center;"><?= Html::encode('QNum') ?></th>
                                    <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Service Name') ?></th>
                                    <th style="font-size: 10pt; text-align: center;"><?= Html::encode('ห้องตรวจ') ?></th>
                                    <th style="font-size: 10pt; text-align: center;"><?= Html::encode('รายการคำสั่ง') ?></th>
                                    <th style="font-size: 10pt; text-align: center;"><?= Html::encode('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 14pt; text-align: center;">-</td>
                                    <td style="font-size: 14pt; text-align: center;">-</td>
                                    <td style="font-size: 14pt; text-align: center;">-</td>
                                    <td style="font-size: 14pt; text-align: center;">-</td>
                                    <td style="font-size: 14pt; text-align: center;">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php echo $this->render('modal'); ?>
<?php
Modal::begin([
    'id' => 'modal-counter',
    'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
    . Html::a('Call', false, ['class' => 'btn btn-success', 'onclick' => 'App.Call(this);']),
]);
?>
<div id="content-counter">
    
</div>
<?php Modal::end();?>
<?php
$baseUrl = Url::base(true);
$this->registerJs(<<< JS
$(function () {
    
    if (localStorage.getItem("servicegroup") === 'ห้องตรวจโรคอายุรกรรม') {
        $("#servicegroup").val(2).trigger("change");
    } else if (localStorage.getItem("servicegroup") === 'คัดกรองผู้ป่วยนอก') {
        //localStorage.setItem("servicegroup", "คัดกรองผู้ป่วยนอก");
        $("#servicegroup").val(1).trigger("change");
    }
    /*
     QueryTableCalling($('#servicegroup :selected').val());
     QueryTableWaiting($('#servicegroup :selected').val());
     QueryTableHoldlist($('#servicegroup :selected').val());
     */
    /* Socket เวลาออกบัตร ให้แสดงข้อมุลอัตโนมัติ */
    var socket = io.connect('http://' + window.location.hostname + ':3000');

    socket.on('request_service', function (data) {
        var arr = [];
        $('input.icheckbox_square-green').each(function () {
            if ($(this).is(':checked'))
            {
                arr.push($(this).val());
            }
        });
        if(arr.length === 0){
            App.QueryTableWaiting($('#servicegroup :selected').val());
            App.QueryTableWaitingOrder($('#servicegroup :selected').val());
            $('#notif_audio')[0].play();
        }
    });
    /* Socket เวลาเรียกคิว ให้แสดงข้อมุลอัตโนมัติ */
    socket.on('request_calling', function (data) {
        App.QueryTableCalling($('#servicegroup :selected').val());
        App.QueryTableWaiting($('#servicegroup :selected').val());
        App.QueryTableHoldlist($('#servicegroup :selected').val());
        App.QueryTableWaitingOrder($('#servicegroup :selected').val());
        //console.log(data.qnum);
        $('#notif_audio')[0].play();
    });
    /* Socket Event Delete */
    socket.on('request_delete_hold_recall', function (data) {
        //
        if(data.state === 'Delete' || data.state === 'Hold' || data.state === 'End'){
            App.QueryTableCalling($('#servicegroup :selected').val());
            App.QueryTableWaiting($('#servicegroup :selected').val());
            App.QueryTableHoldlist($('#servicegroup :selected').val());
            App.QueryTableWaitingOrder($('#servicegroup :selected').val());
        }
    });
});
App = {
    Apply: function(){
        var self = this;
        var ServiceGroupID = $('#servicegroup :selected').val() || 0; /*เก็บค่า id Service */
        if (ServiceGroupID === 0) {
            swal("กรุณาเลือก Service", "", "warning");
        } else {
            self.QueryTableCalling(ServiceGroupID);
            self.QueryTableWaiting(ServiceGroupID);
            self.QueryTableHoldlist(ServiceGroupID);
        }
    },
    /* Query Table Calling to display */
    QueryTableCalling : function (ServiceGroupID){
        $.ajax({
            url: '$baseUrl/main/default/tablecalling',
            type: 'POST',
            data: {ServiceGroupID: ServiceGroupID},
            dataType: 'json',
            success: function (result) {
                $('#tb-calling-content').html(result);
                $('#table-calling').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "info": true,
                    "language": {
                        "lengthMenu": "_MENU_",
                    },
                    "ordering": false,
                    //"paging": false,
                    "responsive": true
                });
            },
            error: function (xhr, status, error) {
                swal(error, "", "error");
            }
        });
    },
    /* Query Table Waitiing to display */
    QueryTableWaiting : function(ServiceGroupID){
        var self = this;
        $.ajax({
            url: '$baseUrl/main/default/tablewaiting',
            type: 'POST',
            data: {ServiceGroupID: ServiceGroupID},
            dataType: 'json',
            success: function (result) {
                $('#tb-waiting-content').html(result);
                var table = $('#table-waiting').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "responsive": true,
                    "info": true,
                    "language": {
                        "lengthMenu": "_MENU_",
                    },
                    "ordering": false,
                    /*"columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ]*/
                });
                self.initCheckbox();
                /*var data = table.rows(0).data();
                var indexes = table.rows().eq( 0 ).filter( function (rowIdx) {
                    var idInput = table.cell( rowIdx, 0 ).data();
                    $('#' + idInput).iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green'
                    });
                    console.log(table.cell( rowIdx, 0 ).data());
                } );*/
            },
            error: function (xhr, status, error) {
                swal(error, "", "error");
            }
        });
    },
    /* Query Table Waitiing to display */
    QueryTableHoldlist: function(ServiceGroupID){
        $.ajax({
            url: '$baseUrl/main/default/tableholdlist',
            type: 'POST',
            data: {ServiceGroupID: ServiceGroupID},
            dataType: 'json',
            success: function (result) {
                $('#tb-holdlist-content').html(result);
                $('#table-holdlist').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "responsive": true,
                    "info": true,
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
    /* Query Table WaitingOrder to display */
    QueryTableWaitingOrder : function(ServiceGroupID){
        $.ajax({
            url: '$baseUrl/main/default/tablewaitingorder',
            type: 'POST',
            data: {ServiceGroupID: ServiceGroupID},
            dataType: 'json',
            success: function (result) {
                $('#tb-waitingorder-content').html(result);
                $('#table-waitingorder').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "responsive": true,
                    "info": true,
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
    /* Function Select */
    SelectCall: function(serviceid){
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        var QNumber = $('input[id=QNumber]').val() || null; //เก็บค่า QNumber
        var ServiceGroupID = $('#servicegroup :selected').val() || null; //เก็บค่า ServiceGroupID
        var self = this;
        if (ServiceGroupID === null || ServiceGroupID === '') {
            swal("กรุณาเลือก Service!", "", "warning");
        } else if (QNumber === null || QNumber === '') {
            swal("กรุณากรอกเลขคิวหรือบาร์โค้ด!", "", "warning");
        } else if ($('#sub-servicegroup').val() === null || $('#sub-servicegroup').val() === '') {
            swal("กรุณาเลือกช่องบริการหรือห้องตรวจ!", "", "warning");
        }else {
            $.ajax({
                url: '$baseUrl/main/default/checkqnum',
                type: 'POST',
                data: {QNumber: QNumber},
                dataType: 'json',
                success: function (result) {
                    if (result === 'ไม่มีหมายเลขคิว') {
                        swal(result, "", "error");
                    } else {
                        var counters = [$('#sub-servicegroup').val()];
                        swal({
                            title: 'ยืนยัน?',
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Call'
                        }).then(function () {
                            $.ajax({
                                url: '$baseUrl/main/default/call',
                                type: 'POST',
                                data: {QNumber: QNumber, counters: counters},
                                dataType: 'json',
                                success: function (result) {
                                    if (result === 'เรียกซ้ำ') {
                                        swal(result, "", "error");
                                    } else if (result === 'ไม่มีหมายเลขคิว') {
                                        swal(result + ' ' + QNumber, "", "warning");
                                    } else {
                                        //$("#tbody-tablecalling").prepend(result);
                                        socket.emit('request_calling', {
                                            request_calling: QNumber,
                                            service_name: $('#servicegroup :selected').text(),
                                        });
                                        self.HiddenInput();
                                        $('#modal-counter').modal('hide');
                                        self.ModernBlink('#tr-' + QNumber);
                                        $('input[id=QNumber]').val('');
                                    }
                                },
                                error: function (xhr, status, error) {
                                    swal(error, "", "error");
                                }
                            });
                        }, function (dismiss) {
                            
                        });
                        /*
                        $('#content-counter').html(result.content);
                        if ($('.hide-service').hasClass('display-none') && ServiceGroupID === '1') {
                            $('.hide-counter').addClass('display-none');
                            $('.hide-counter').hide();
                            $('.hide-service').removeClass('display-none');
                            $('.hide-service').show();
                        } else if ($('.hide-counter').hasClass('display-none') && ServiceGroupID === '2') {
                            $('.hide-service').addClass('display-none');
                            $('.hide-service').hide();
                            $('.hide-counter').removeClass('display-none');
                            $('.hide-counter').show();
                        }
                        $('#modal-counter').modal('show');
                        $('.modal-title').html(ServiceGroupID === '1' ? "เลือกช่องบริการ Q " + QNumber : "เลือกห้องตรวจ Q " + QNumber);
                        */
                    }
                },
                error: function (xhr, status, error) {
                    swal(error, "", "error");
                }
            });
        }
    },
    HiddenInput:function(){
        $('.hide-input1').addClass('display-none');
        $('.hide-input1').hide();
        $('.hide-input2').addClass('display-none');
        $('.hide-input2').hide();
        $('.hide-input-call').addClass('display-none');
        $('.hide-input-call').hide();
        $('#QNumber').val(null);
        $("#Counter1").val(null).trigger("change");
        $("#Counter2").val(null).trigger("change");
        $("div[id=step-0]").css("display", "none");
    },
    /* Call */
    Call : function(){
        var self = this;
        var QNumber = $('input[id=QNumber]').val() || null; //เก็บค่า QNumber
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        var ServiceGroupID = $('#servicegroup :selected').val() || null; //เก็บค่า ServiceGroupID
        var counters = new Array();
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                counters.push($(this).val());
            }
        });
        if (counters.length === 0) {
            if (ServiceGroupID === '1') {
                swal("เลือกช่องบริการ!", "", "warning");
            } else {
                swal("เลือกห้องตรวจ!", "", "warning");
            }
        } else {
            $.ajax({
                url: '$baseUrl/main/default/call',
                type: 'POST',
                data: {QNumber: QNumber, counters: counters},
                dataType: 'json',
                success: function (result) {
                    if (result === 'เรียกซ้ำ') {
                        swal(result, "", "error");
                    } else if (result === 'ไม่มีหมายเลขคิว') {
                        swal(result + ' ' + QNumber, "", "warning");
                    } else {
                        //$("#tbody-tablecalling").prepend(result);
                        socket.emit('request_calling', {
                            request_calling: QNumber,
                            service_name: $('#servicegroup :selected').text(),
                        });
                        self.HiddenInput();
                        $('#modal-counter').modal('hide');
                        self.ModernBlink('#tr-' + QNumber);
                    }
                },
                error: function (xhr, status, error) {
                    swal(error, "", "error");
                }
            });
        }
    },
    /* blinker กระพริบเวลาเรียก */
    blinker: function (id){
        var varCounter = 0;
        var intervalId = setInterval(function () {
            varCounter++;
            if ($(id).hasClass('success')) {
                $(id).removeClass('success');
                $(id).addClass('default');
            } else {
                $('tr.default').removeClass('default');
                $(id).addClass('success');
            }
            if (varCounter === 10) {
                clearInterval(intervalId);
            }
        }, 500);
    },
    blinkercall : function(id){
        if (document.getElementById(id))
        {
            var varCounter = 0;
            var intervalId = setInterval(function () {
                varCounter++;
                var d = document.getElementById(id);
                d.style.color = (d.style.color == 'black' ? 'red' : 'black');
                if (varCounter === 5) {
                    clearInterval(intervalId);
                    d.style.color = '#6A6C6F';
                }
            }, 500);
        }
    },
    /* Delete */
    Delete : function(e){
        var q_ids = (e.getAttribute("data-id"));
        var q_num = (e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        swal({
            title: "Delete " + q_num + " ?",
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#74D348',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            }).then(function () {
                $.ajax({
                    url: '$baseUrl/main/default/delete',
                    type: 'POST',
                    data: {q_ids: q_ids},
                    dataType: 'json',
                    success: function (result) {
                        socket.emit('request_delete_hold_recall', {
                            request_delete_hold_recall: result,
                            state: 'Delete',
                            service_name: $('#servicegroup :selected').text(),
                        });
                        swal.close();
                    },
                    error: function (xhr, status, error) {
                        swal(error, "", "error");
                    }
                });
            }, function (dismiss) {

        });
    },
    /* Hold */
    Hold : function(e){
        var self = this;
        var q_ids = (e.getAttribute("data-id"));
        var q_num = (e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        self.HiddenInput();
        swal({
            title: "Hold " + q_num + " ?",
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#74D348',
            confirmButtonText: 'Confirm!',
            cancelButtonText: 'Cancel',
            }).then(function () {
                $.ajax({
                    url: '$baseUrl/main/default/hold',
                    type: 'POST',
                    data: {q_ids: q_ids},
                    dataType: 'json',
                    success: function (result) {
                        socket.emit('request_delete_hold_recall', {
                            request_delete_hold_recall: result,
                            state: 'Hold',
                            service_name: $('#servicegroup :selected').text(),
                        });
                        swal.close();
                    },
                    error: function (xhr, status, error) {
                        swal(error, "", "error");
                    }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    
                }
        });
    },
    /* Call Button */
    CallButton : function(e){
        var self = this;
        var QNumber = (e.getAttribute("qnum"));
        //var serviceid = (e.getAttribute("serviceid"));
        var serviceid = $('#servicegroup :selected').val() || null; //เก็บค่า ServiceGroupID
        //$('input[id=QNumber]').val(e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        //self.SelectCall(serviceid);
        if (serviceid === null || serviceid === '') {
            swal("กรุณาเลือก Service!", "", "warning");
        } else if (QNumber === null || QNumber === '') {
            swal("กรุณากรอกเลขคิวหรือบาร์โค้ด!", "", "warning");
        }else if ($('#sub-servicegroup').val() === null || $('#sub-servicegroup').val() === '') {
            swal("กรุณาเลือกช่องบริการหรือห้องตรวจ!", "", "warning");
        } else {
            var counters = [$('#sub-servicegroup').val()];
            swal({
                title: 'ยืนยัน?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Call'
            }).then(function () {
                $.ajax({
                    url: '$baseUrl/main/default/call',
                    type: 'POST',
                    data: {QNumber: QNumber, counters: counters},
                    dataType: 'json',
                    success: function (result) {
                        if (result === 'เรียกซ้ำ') {
                            swal(result, "", "error");
                        } else if (result === 'ไม่มีหมายเลขคิว') {
                            swal(result + ' ' + QNumber, "", "warning");
                        } else {
                            //$("#tbody-tablecalling").prepend(result);
                            socket.emit('request_calling', {
                                request_calling: QNumber,
                                service_name: $('#servicegroup :selected').text(),
                            });
                            self.HiddenInput();
                            $('#modal-counter').modal('hide');
                            self.ModernBlink('#tr-' + QNumber);
                            $('input[id=QNumber]').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        swal(error, "", "error");
                    }
                });
            }, function (dismiss) {
                
            });
        }
        
        //$('html, body').animate({scrollTop: 0}, 300);
        //blinkercall('Select-Counter' + ServiceGroupID);
    },
    /* Recall */
    Recall: function(e){
        var self = this;
        var caller_ids = (e.getAttribute("data-id"));
        var q_num = (e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        self.HiddenInput();
        swal({
            title: "Recall " + q_num + " ?",
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#74D348',
            confirmButtonText: 'Confirm!',
            cancelButtonText: 'Cancel',
            }).then(function () {
                $.ajax({
                    url: '$baseUrl/main/default/recall',
                    type: 'POST',
                    data: {caller_ids: caller_ids},
                    dataType: 'json',
                    success: function (result) {
                        /* result == q_num */
                        socket.emit('request_delete_hold_recall', {
                            request_delete_hold_recall: result,
                            state: 'recall',
                            service_name: $('#servicegroup :selected').text(),
                        });
                        //self.ModernBlink('#tr-' + q_num);
                        swal.close();
                    },
                    error: function (xhr, status, error) {
                        swal(error, "", "error");
                    }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    
                }
        });
    },
    /* End */
    End : function(e){
        var self = this;
        var q_ids = (e.getAttribute("data-id"));
        var q_num = (e.getAttribute("qnum"));
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        self.HiddenInput();
        swal({
            title: "End " + q_num + " ?",
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#74D348',
            confirmButtonText: 'Confirm!',
            cancelButtonText: 'Cancel',
            }).then(function () {
                $.ajax({
                    url: '$baseUrl/main/default/end',
                    type: 'POST',
                    data: {q_ids: q_ids},
                    dataType: 'json',
                    success: function (result) {
                        socket.emit('request_delete_hold_recall', {
                            request_delete_hold_recall: result,
                            state: 'End',
                            service_name: $('#servicegroup :selected').text(),
                        });
                        swal.close();
                    },
                    error: function (xhr, status, error) {
                        swal(error, "", "error");
                    }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    
                }
        });
    },
    /* Reset From */
    Reset : function(){
        var self = this;
        self.HiddenInput();
    },
    ModernBlink : function(id) {
        $(id).modernBlink({
            duration: 1000, // Duration specified in milliseconds (integer)
            iterationCount: 7, // Number of times the element should blink ("infinite" or integer)
            auto: true // Whether to start automatically or not (boolean)
        });
    },
    initCheckbox: function(){
        var self = this;
        var values = 0;
        $('input.icheckbox_square-green').on('click', function (e) {
            if ($(this).is(':checked'))
            {
                values = self.checkChecked();
                if(values.length > 3){
                    swal("เลือกได้ไม่เกิน 3 คิว", "", "error");
                    $(this).prop('checked', false);
                }
            }
        }); 
    },
    checkChecked : function (){
        var self = this;
        var arr = [];
        $('input.icheckbox_square-green').each(function () {
            if ($(this).is(':checked'))
            {
                arr.push($(this).val());
            }
        });
        return arr;
    },
    CallSelect: function(){
        var self = this;
        values = self.checkChecked();
        if(values.length > 0){
            if ($('#sub-servicegroup').val() === null || $('#sub-servicegroup').val() === '') {
                swal("กรุณาเลือกช่องบริการหรือห้องตรวจ!", "", "warning");
            }else{
                swal({
                title: 'ยืนยัน?',
                //input: 'select',
                confirmButtonText: 'Confirm',
                inputOptions: {
                    '11': 'ห้องตรวจ 1',
                    '12': 'ห้องตรวจ 2',
                    '13': 'ห้องตรวจ 3',
                    '14': 'ห้องตรวจ 4',
                    '15': 'ห้องตรวจ 5',
                    '16': 'ห้องตรวจ 6',
                    '17': 'ห้องตรวจ 7',
                    '18': 'ห้องตรวจ 8',
                    '19': 'ห้องตรวจ 9',
                    '20': 'ห้องตรวจ 10',
                },
                inputPlaceholder: 'เลือกห้องตรวจ',
                showCancelButton: true,
                inputValidator: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value) {
                            resolve();
                        } else {
                            reject('กรุณาเลือกห้องตรวจ!');
                        }
                    });
                }
                }).then(function (result) {
                    var socket = io.connect('http://' + window.location.hostname + ':3000');
                    $.ajax({
                        url: '$baseUrl/main/default/call-multiple',
                        type: 'POST',
                        data: {counterid: $('#sub-servicegroup').val(),values:values},
                        dataType: 'json',
                        success: function (data) {
                            socket.emit('request_calling', {
                                request_calling: data,
                                service_name: $('#servicegroup :selected').text(),
                            });
                        },
                        error: function (xhr, status, error) {
                            swal(error, "", "error");
                        }
                    });
                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === 'cancel') {
                        console.log(dismiss);
                    }
                });
            }
        }else{
            swal("ไม่ได้เลือกรายการใด", "", "error");
        }
    },
    EditLab: function (e){
        var self = this;
        var q_ids = (e.getAttribute("data-id"));
        var btnsave = document.getElementById("btn-saveorder"); 
        btnsave.setAttribute('func', e.getAttribute("func"));
        $('.modal-title').html("รายการคำสั่ง QNum " + (e.getAttribute("qnum")));
        $.ajax({
            type: 'POST',
            url: '$baseUrl/main/default/getmain-orderlist',
            data: {q_ids: q_ids},
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
    SaveOrder : function(e){
        var form = $('#form-order');
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        $.ajax({
            type: 'POST',
            url: '$baseUrl/main/default/save-orderlist',
            data: $( form ).serialize(),
            dataType: "json",
            success: function (result) {
                $("#modal-orderdetail").modal('hide');
                socket.emit('request_service', {
                    request_service: $('#servicegroup :selected').val()
                });
            },
            error: function (xhr, status, error) {
                
            },
        });
    }
};

/* SetLocalStorage On Change ServiceGroup */
$('#servicegroup').on('change', function (e) {
    var ServiceGroupName = $(this).find("option:selected").text() || null;
    App.HiddenInput();
    if (ServiceGroupName !== "Select Service...") {
        if (localStorage.getItem("servicegroup") === ServiceGroupName) {
            localStorage.setItem("servicegroup", ServiceGroupName);
        } else {
            localStorage.setItem("servicegroup", ServiceGroupName);
        }
    } else {
        localStorage.removeItem("servicegroup");
    }
    App.QueryTableCalling($(this).find("option:selected").val());
    App.QueryTableWaiting($(this).find("option:selected").val());
    App.QueryTableHoldlist($(this).find("option:selected").val());
    if (ServiceGroupName === "ห้องตรวจโรคอายุรกรรม") {
        App.QueryTableWaitingOrder($(this).find("option:selected").val());
        $('.waitingorder').removeClass('display-none');
        $('.waitingorder').show();
    } else {
        $('.waitingorder').addClass('display-none');
        $('.waitingorder').hide();
    }

});

$('#form-horizontal').on('beforeSubmit', function (e) {
    e.preventDefault();
    var dataArray = $(this).serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });
    //console.log(dataObj['QNumber']);
    App.SelectCall(0);
    return false;
});

$("#QNumber").on("keyup", function () {
    var txtval = $(this).val() || null;
    if (txtval === null) {
        App.HiddenInput();
    }
});

/* On Change Counter1 */
$('#Counter1').on('change', function (e) {
    var CounterName = $(this).find("option:selected").text() || null;
    if (CounterName !== "Select...") {
        $('.hide-input-call').removeClass('display-none');
        $('.hide-input-call').show();
    } else {
        $('.hide-input-call').addClass('display-none');
        $('.hide-input-call').hide();
    }
});
/* On Change Counter1 */
$('#Counter2').on('change', function (e) {
    var CounterName = $(this).find("option:selected").text() || null;
    if (CounterName !== "Select...") {
        $('.hide-input-call').removeClass('display-none');
        $('.hide-input-call').show();
    } else {
        $('.hide-input-call').addClass('display-none');
        $('.hide-input-call').hide();
    }
});

$('#modal-counter').on('shown.bs.modal', function () {
    //$('input[type=checkbox]').checkboxX('reset');
})
$('#modal-counter').on('hidden.bs.modal', function (e) {
    //$('input[type=checkbox]').checkboxX('reset');
    App.HiddenInput();
});
$(function() {
    
});

function setSessionDepdop(id){
    $.ajax({
        type: 'POST',
        url: '$baseUrl/main/default/set-session-depdop',
        data: {id:id},
        dataType: "json",
        success: function (result) {
            
        },
        error: function (xhr, status, error) {
            
        },
    });
}
JS
);
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/howler/dist/howler.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php // $this->registerJsFile(Yii::getAlias('@web') . '/js/main/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.modern-blink.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>