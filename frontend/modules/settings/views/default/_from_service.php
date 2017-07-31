
<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\settings\models\TbServiceRoute;
?>
<?php $formnew = ActiveForm::begin(['enableAjaxValidation' => true, 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'service_name', ['label' => 'service_name', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-10">
        <?= $formnew->field($model, 'service_name', ['showLabels' => false])->textInput(['placeholder' => '']); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'service_groupid', ['label' => 'service_groupid', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?=
        $formnew->field($model, 'service_groupid', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroupid', 'servicegroup_name'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'service_groupid']
        ]);
        ?>
    </div>
    <?= Html::activeLabel($model, 'service_route', ['label' => 'service_route', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?=
        $formnew->field($model, 'service_route', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbServiceRoute::find()->all(), 'ids', 'service_route'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'service_route']
        ]);
        ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'prn_profileid', ['label' => '', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'prn_profileid', ['showLabels' => false])->textInput(['placeholder' => 'prn_profileid']); ?>
    </div>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'prn_copyqty', ['showLabels' => false])->textInput(['placeholder' => 'prn_copyqty']); ?>
    </div>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_numdigit', ['showLabels' => false])->textInput(['placeholder' => 'prn_copyqty']); ?>
    </div>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_prefix', ['showLabels' => false])->textInput(['placeholder' => 'service_prefix']); ?>
    </div>
    <div class="col-sm-2">
        <?= $formnew->field($model, 'service_status', ['showLabels' => false])->textInput(['placeholder' => 'service_status']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

