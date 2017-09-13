<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $formnew = ActiveForm::begin(['enableAjaxValidation' => true, 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'service_md_name', ['label' => 'ชื่อแพทย์', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-8">
        <?= $formnew->field($model, 'service_md_name', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>