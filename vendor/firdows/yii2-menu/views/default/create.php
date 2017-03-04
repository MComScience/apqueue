<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model firdows\menu\models\Menu */

$this->title = Yii::t('menu', 'Create Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='row'>
    
    <div class='col-xs-12 col-sm-6 col-md-12'>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div><!--box-body pad-->
 </div><!--box box-info-->
