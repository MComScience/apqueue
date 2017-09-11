<?php
use yii\bootstrap\Tabs;
use yii\helpers\Url;
$action = Yii::$app->controller->action->id;
?>
<?php 
echo Tabs::widget([
    'items' => [
        [
            'label' => 'จอแสดงผล',
            'url' => Url::to(['/settings/default/display']),
            'active' => $action == 'display' ? true : false,
        ],
        [
            'label' => 'แพทย์',
            'url' => Url::to(['/settings/default/md-name']),
            'active' => $action == 'md-name' ? true : false,
        ],
        [
            'label' => 'ช่องบริการ',
            'url' => Url::to(['/settings/default/counter-service']),
            'active' => $action == 'counter-service' ? true : false,
        ],
        [
            'label' => 'กลุ่มบริการ',
            'url' => Url::to(['/settings/default/service-group']),
            'active' => $action == 'service-group' ? true : false,
        ],
        [
            'label' => 'เส้นทางการบริการ',
            'url' => Url::to(['/settings/default/service-route']),
            'active' => $action == 'service-route' ? true : false,
        ],
        [
            'label' => 'การบริการ',
            'url' => Url::to(['/settings/default/service']),
            'active' => $action == 'service' ? true : false,
        ],
        [
            'label' => 'เสียงเรียก',
            'url' => Url::to(['/settings/default/sound-list']),
            'active' => $action == 'sound-list' ? true : false,
        ],
        [
            'label' => 'รีเซ็ตคิว',
            'url' => Url::to(['/settings/default/reset-q']),
            'active' => $action == 'reset-q' ? true : false,
        ],
    ],
    'renderTabContent' => false
]);
?>
