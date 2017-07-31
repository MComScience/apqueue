<?php
use yii\bootstrap\Tabs;
use yii\helpers\Url;
$action = Yii::$app->controller->action->id;
?>
<?php 
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Display',
            'url' => Url::to(['/settings/default/display']),
            'active' => $action == 'display' ? true : false,
        ],
        [
            'label' => 'Counter Service',
            'url' => Url::to(['/settings/default/counter-service']),
            'active' => $action == 'counter-service' ? true : false,
        ],
        [
            'label' => 'Service Group',
            'url' => Url::to(['/settings/default/service-group']),
            'active' => $action == 'service-group' ? true : false,
        ],
        [
            'label' => 'Service Route',
            'url' => Url::to(['/settings/default/service-route']),
            'active' => $action == 'service-route' ? true : false,
        ],
        [
            'label' => 'Service',
            'url' => Url::to(['/settings/default/service']),
            'active' => $action == 'service' ? true : false,
        ],
        [
            'label' => 'Sounds',
            'url' => Url::to(['/settings/default/sound-list']),
            'active' => $action == 'sound-list' ? true : false,
        ],
        [
            'label' => 'Reset Queue',
            'url' => Url::to(['/settings/default/reset-q']),
            'active' => $action == 'reset-q' ? true : false,
        ],
    ],
    'renderTabContent' => false
]);
?>
