<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\icons\Icon;
use frontend\assets\DatatablesAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\SweetAlertAsset;

DatatablesAsset::register($this);
WaitMeAsset::register($this);
SweetAlertAsset::register($this);
$this->title = Yii::$app->name;
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
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/main/order-check.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
