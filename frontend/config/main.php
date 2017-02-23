<?php

use \yii\web\Request;

$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'APQUEUE APP',
    'language' => 'th-TH', // ตั้งค่าภาษาไทย
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        # Yii2-User Extension
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'], #'admin',
            'controllerMap' => [
                'profile' => [
                    'class' => 'common\themes\homer\controllers\ProfileController',
                ],
                'settings' => [
                    'class' => 'common\themes\homer\controllers\SettingsController',
                ],
                'security' => [
                    'class' => 'dektrium\user\controllers\SecurityController',
                    //'layout' => '//login',
                ],
                'recovery' => [
                    'class' => 'dektrium\user\controllers\RecoveryController',
                    //'layout' => '//login',
                ],
                'registration' => [
                    'class' => 'common\themes\homer\controllers\RegistrationController',
                    //'layout' => '//login',
                ],
            ],
        /*
          'mailer' => [
          'sender' => ['procurementuch@gmail.com' => 'KM4'], // or ['no-reply@myhost.com' => 'Sender name']
          'welcomeSubject' => 'Welcome subject',
          'confirmationSubject' => 'Confirmation subject',
          'reconfirmationSubject' => 'Email change subject',
          'recoverySubject' => 'Recovery Password',
          ], */
        ],
        # Yii2-Admin Extension
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // left-menu, right-menu, top-menu
            'mainLayout' => '@app/themes/homer/layouts/main.php',
            'menus' => [
                'assignment' => [
                    'label' => 'Assignments' // change label
                ],
                'role' => [
                    'label' => 'Roles' // change label
                ],
                'permission' => [
                    'label' => 'Permissions' // change label
                ],
                'route' => [
                    'label' => 'Routes' // change label
                ],
                'rule' => [
                    'label' => 'Rules' // change label
                ],
            //'route' => null, // disable menu
            ],
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'report' => [
            'class' => 'app\modules\report\Module',
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'kiosk' => [
            'class' => 'app\modules\kiosk\Module',
        ],
        'menu' => [
            'class' => 'firdows\menu\Module',
        ],
         'menuconfig' => [
            'class' => 'app\modules\menu\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
        ],
        # Yii2-User Extension
        'user' => [
            'identityClass' => 'dektrium\user\models\User', // or 'common\models\User'
            'identityCookie' => [
                'name' => '_frontendIdentity',
                'path' => '/',
                'httpOnly' => true
            ],
            'enableAutoLogin' => true,
        //'authTimeout' => 16000,
        ],
        # Yii2-User Extension
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path' => '/',
            //'lifetime' => 60,
            ],
            'timeout' => 3600 * 3,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'display' => 'kiosk/default/display1',
                'display2' => 'kiosk/default/display2',
                'ordercheck' => 'main/default/order-check',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                //'<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                # Modules
                '<module:\w+>' => '<module>/default/index',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
            //'<module:\w+>/<controller:\w+>/<action>' => '<module>/<controller>/<action>',
            ]
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@frontend/views' => '@frontend/themes/homer',
                    '@dektrium/user/views' => '@common/themes/homer/views/user',
                ],
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'user/security/login',
            'user/recovery/request',
            'user/recovery/reset',
            'user/registration/regis',
            'user/registration/confirm',
            'user/recover/*',
            'kiosk/default/display1',
            'kiosk/default/table-display'
        ]
    ],
    'params' => $params,
];
