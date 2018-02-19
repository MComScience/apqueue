<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model msoft\menu\models\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="fullscreen"><i class="fa fa-expand"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Details Menus
            </div>
            <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('menu', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a(Yii::t('menu', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('menu', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </p>

                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'menu_category_id',
                        'parent_id',
                        'title',
                        'router',
                        'parameter',
                        'icon',
                        'status',
                        'item_name',
                        'itemsList',
                        'target',
                        'protocol',
                        'home',
                        'sort',
                        'language',
                        'assoc',
                        'created_at',
                        'created_by',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>