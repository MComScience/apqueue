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
use frontend\assets\TourAsset;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);
DatatablesAsset::register($this);
TourAsset::register($this);

$this->title = 'เรียกคิว';
?>
<audio id="notif_audio">
    <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
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
            <?= Html::label('Service', 'Service', ['class' => 'col-sm-1 control-label no-padding-right', 'style' => 'font-size: 14pt;']) ?>
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
                ]);
                ?>
            </div>
            <?php /*
              <div class="col-sm-1">
              <?php // Html::a(Icon::show('hand-pointer-o', []) . 'Apply', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'Apply(this);']) ?>
              </div> */
            ?>
            <?= Html::label('QNumber', 'Queue Number', ['class' => 'col-sm-2 control-label no-padding-right', 'style' => 'font-size: 14pt;']) ?>
            <div class="col-sm-3">
                <?= Html::input('text', 'QNumber', '', ['class' => 'form-control input-lg', 'id' => 'QNumber', 'autofocus' => true, 'placeholder' => 'กรอกหมายเลขคิวหรือบาร์โค้ด', 'required' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= Html::a('Clear', false, ['class' => 'btn btn-danger btn-lg', 'onclick' => 'Reset(this);']) ?>
                <?= Html::a('<i class="fa fa-check"></i> ' . 'Call', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'SelectCall(this);',]) ?>
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
    <div class="col-xs-12 col-sm-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="pe-7s-volume1"></i> <?= Html::encode('Calling') ?>
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
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-hourglass-3"></i><?= Html::encode('Waiting') ?>
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
    <div class="col-xs-12 col-sm-6">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-hand-stop-o"></i><?= Html::encode('Hold') ?>
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
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-xs-12 col-sm-12  waitingorder display-none" style="display: none" >
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="fa fa-list-alt"></i>
                <?= Html::encode('Waiting Order') ?>
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
<?php echo $this->render('modal'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/main/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>