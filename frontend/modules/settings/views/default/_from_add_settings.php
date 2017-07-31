<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $formnew = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'hold_query', ['label' => 'hold query', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-8">
        <?= $formnew->field($model, 'hold_query', ['showLabels' => false])->textarea(['rows' => 10]); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'limit', ['label' => 'จำนวนรายการที่แสดงบนหน้าจอ', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'limit', ['showLabels' => false])->textInput(['type' => 'number','min' => 1]); ?>
    </div>
    <?= Html::activeLabel($model, 'qhold_label', ['label' => 'Q Hold Label', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'qhold_label', ['showLabels' => false])->textInput([]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

