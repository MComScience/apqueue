<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model firdows\menu\models\MenuCategory */
/* @var $form yii\widgets\ActiveForm */
?>

        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="fullscreen"><i class="fa fa-expand"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Create Menus Category
            </div>
            <div class="panel-body">
                <div class="menu-category-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'discription')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->dropDownList([ 1 => '1', 0 => '0',], ['prompt' => '']) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('menu', 'Create') : Yii::t('menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>