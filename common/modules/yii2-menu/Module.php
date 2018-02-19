<?php

namespace msoft\menu;
use Yii;
/**
 * menu module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'msoft\menu\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        $this->layout = 'left-menu.php';
        
        
        if (!isset(Yii::$app->i18n->translations['menu'])) {
            Yii::$app->i18n->translations['menu'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@msoft/menu/messages'
            ];
        }
        
        parent::init();

        // custom initialization code goes here
    }

}
