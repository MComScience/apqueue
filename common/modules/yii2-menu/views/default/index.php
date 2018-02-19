<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use msoft\menu\models\Menu;
use msoft\menu\models\MenuCategory;

//use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel msoft\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'ระบบจัดการเมนู');
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
                Lists Menus
            </div>
            <div class="panel-body">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsive' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'title',
                            'format' => 'html',
                            'value' => function($model) {
                                return Html::a($model->iconShow . ' ' . $model->title, ['/menu/default/view', 'id' => $model->id]);
                            }
                                ],
                                [
                                    'attribute' => 'menu_category_id',
                                    'filter' => MenuCategory::getList(),
                                    'value' => function($model) {
                                        return $model->menuCategory->title;
                                    }
                                ],
                                [
                                    'attribute' => 'router',
                                    'filter' => Menu::getRouterDistinct(),
                                ],
                                [
                                    'attribute' => 'parent_id',
                                    'filter' => Menu::getParentDistinct(),
                                    'value' => function($model) {
                                        return $model->parentTitle;
                                    }
                                ],
                                // 'parameter',
                                // 'icon',
                                [
                                    'attribute' => 'status',
                                    'filter' => Menu::getItemStatus(),
                                    'value' => 'statusLabel',
                                ],
                                //'item_name',                      
                                [
                                    'attribute' => 'items',
                                    'filter' => Menu::getItemsListDistinct(),
                                    'value' => 'itemsList',
                                    'headerOptions' => ['width' => '200']
                                ],
                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]);
                        ?>
            </div>
        </div>
    </div>
</div>

