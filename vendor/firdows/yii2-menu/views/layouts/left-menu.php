<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
use kartik\widgets\SideNav;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>


<div class="row">
    <div class="col-md-3">
        <?php
        echo SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'encodeLabels' => false,
            'headingOptions' => ['class' => 'head-style'],
            'heading' => 'Manage Menus',
            'items' => [
                ['label' => 'Add Menu<i class="glyphicon glyphicon-chevron-right pull-right"></i>', 'icon' => 'plus', 'url' => Url::to(['/menu/default/create']), 'active' => (Yii::$app->request->url == '/yii2homer/menu/default/create')],
                ['label' => 'Lists Menu<i class="glyphicon glyphicon-chevron-right pull-right"></i>', 'icon' => 'list', 'url' => Url::to(['/menu']), 'active' => (Yii::$app->request->url == '/yii2homer/menu')],
                ['label' => 'Add Category Menu<i class="glyphicon glyphicon-chevron-right pull-right"></i>', 'icon' => 'plus', 'url' => Url::to(['/menu/category/create']), 'active' => (Yii::$app->request->url == '/yii2homer/menu/category/create')],
                ['label' => 'Lists Category Menu<i class="glyphicon glyphicon-chevron-right pull-right"></i>', 'icon' => 'list', 'url' => Url::to(['/menu/category']), 'active' => (Yii::$app->request->url == '/yii2homer/menu/category')],
            ],
        ]);
        ?>
    </div>
    <!-- /.col -->


    <div class="col-md-9">
        <?= $content ?>
        <!-- /. box -->
    </div>
    <!-- /.col -->


</div>


<?php $this->endContent(); ?>
