
<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\kiosk\models\TbService;
?>
<?php $formnew = ActiveForm::begin(['enableAjaxValidation' => true, 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'counterservice_name', ['label' => 'counterservice_name', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'counterservice_name', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
    <?= Html::activeLabel($model, 'counterservice_type', ['label' => 'counterservice_type', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'counterservice_type', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'servicegroupid', ['label' => 'servicegroupid', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?=
        $formnew->field($model, 'servicegroupid', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroupid', 'servicegroup_name'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'servicegroupid']
        ]);
        ?>
    </div>
    <?= Html::activeLabel($model, 'serviceid', ['label' => 'counterservice_type', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?=
        $formnew->field($model, 'serviceid', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbService::find()->all(), 'serviceid', 'service_name'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'serviceid']
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($model, 'sound_stationid', ['label' => 'sound_stationid', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'sound_stationid', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
    <?= Html::activeLabel($model, 'sound_typeid', ['label' => 'sound_typeid', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $formnew->field($model, 'sound_typeid', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

