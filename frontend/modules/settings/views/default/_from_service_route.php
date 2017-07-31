
<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $formnew = ActiveForm::begin(['enableAjaxValidation' => true, 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'service_route', ['label' => 'service_route', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_route', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
    <?= Html::activeLabel($model, 'service_group_seq', ['label' => 'service_group_seq', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_group_seq', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
    <?= Html::activeLabel($model, 'service_status', ['label' => 'service_status', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_status', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

