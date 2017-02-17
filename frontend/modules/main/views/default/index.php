<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use yii\helpers\Html;
use kartik\icons\Icon;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\DatatablesAsset;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);
DatatablesAsset::register($this);

$this->title = Yii::$app->name;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-horizontal',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                        //'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
        ]);
        ?>
        <div class="form-group">
            <?= Html::label('Service', 'Service', ['class' => 'col-sm-1 control-label no-padding-right', 'style' => 'font-size: 12pt;']) ?>
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
            <div class="col-sm-1">
                <?= Html::a(Icon::show('hand-pointer-o', []) . 'Apply', false, ['class' => 'btn btn-success btn-lg','onclick' => 'Apply(this);']) ?>
            </div>
            <?= Html::label('Queue Number', 'Queue Number', ['class' => 'col-sm-2 control-label no-padding-right', 'style' => 'font-size: 12pt;']) ?>
            <div class="col-sm-3">
                <?= Html::input('text', 'QNumber', '', ['class' => 'form-control input-lg', 'id' => 'QNumber', 'autofocus' => true, 'placeholder' => 'กรอกหมายเลขคิวหรือบาร์โค้ด']) ?>
            </div>
            <div class="col-sm-2">
                <?= Html::a(Icon::show('check-square-o', []) . 'Select', false, ['class' => 'btn btn-info btn-lg']) ?>
            </div>
        </div>
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
                <div id="tb-hold-content">
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
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/main/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>