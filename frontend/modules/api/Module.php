<?php

namespace app\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        $this->modules = [
            'v1' => [
                'class' => 'app\modules\api\modules\v1\Module',
            ]
        ];

        // custom initialization code goes here
    }
}
