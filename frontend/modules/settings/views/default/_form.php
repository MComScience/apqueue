<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use kartik\widgets\Select2;
use frontend\modules\main\models\TbServicegroup;
use yii\helpers\ArrayHelper;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $formnew = ActiveForm::begin([]); ?>
        <div class="form-group">
            <div class="col-sm-2">
                <?php
                echo $formnew->field($model, 'display_name')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroup_name', 'servicegroup_name'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-sm-1">
                <?=
                $formnew->field($model, 'state')->widget(SwitchInput::classname(), [
                    'pluginOptions' => [
                        'animate' => false
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-1">
                <?= $formnew->field($model, 'font_size') ?>
            </div>
            <div class="col-sm-2">
                <?=
                $formnew->field($model, 'header_color')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Row color ...'],
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb',
                        'showPalette' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?=
                $formnew->field($model, 'column_color')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Column color ...'],
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb'
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?=
                $formnew->field($model, 'font_color')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Font color ...'],
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb'
                    ]
                ]);
                ?>
            </div>
            <?= $formnew->field($model, 'id')->hiddenInput()->label(false) ?>
            <br>
            <div class="col-sm-2">
                <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Add New', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
