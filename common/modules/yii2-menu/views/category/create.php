<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model msoft\menu\models\MenuCategory */

$this->title = Yii::t('menu', 'Create Menu Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div><!--box-body pad-->
</div><!--box box-info-->
