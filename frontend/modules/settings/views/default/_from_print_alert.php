<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $formnew = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'q_printstationid', ['label' => 'Station', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'q_printstationid', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'q_limitqty', ['label' => 'จำนวนที่ต้องการเตือน', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'q_limitqty', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>