<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>PLEASE LOGIN TO APP</h3>
                <small></small>
            </div>
            <div class="hpanel">
                <div class="panel-body">

                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                    <div class="form-group">
                        <label class="control-label" for="username">Username</label>
                        <?=
                                $form
                                ->field($model, 'username', $fieldOptions1)
                                ->label(false)
                                ->textInput(['placeholder' => $model->getAttributeLabel('username')])
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <?=
                                $form
                                ->field($model, 'password', $fieldOptions2)
                                ->label(false)
                                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                        ?>
                    </div>
                    <div class="checkbox">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                    <a class="btn btn-default btn-block" href="#">Register</a>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>HOMER</strong> - Responsive WebApp <br/> Copyright © <?php echo date('Y', time()); ?> KM4. All rights reserved.
        </div>
    </div>
</div>