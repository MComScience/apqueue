<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    # ตั้งค่าการใช้งานภาษาไทย (Language)
    'language' => 'th-TH', // ตั้งค่าภาษาไทย
    # ตั้งค่า TimeZone ประเทศไทย
    'timeZone' => 'Asia/Bangkok', // ตั้งค่า TimeZone
    # Yii2-Admin Extension
    'aliases' => [
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin'
    ],
    'bootstrap' => ['languagepicker','log'],
    'components' => [
    	'authClientCollection' => [
            'class' => \yii\authclient\Collection::className(),
            'httpClient' => [
                'transport' => 'yii\httpclient\CurlTransport',
            ],
            'clients' => [
                /*
                'doh' => [
                    'class' => 'common\components\DohClient',
                    'clientId' => 'e9a91e04cfbb9639f393404551e568aa673da257',
                    'clientSecret' => '3e43bc4267525ebd08189f3bc9476437ed0e78ef',
                ],*/
            ],
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en-US' => 'English', 'th-TH' => 'Thai']
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i a',
            'timeFormat' => 'php:H:i A',
            'timeZone' => 'Asia/Bangkok',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                /*
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                       'from' => ['log@example.com'],
                       'to' => ['admin@example.com', 'developer@example.com'],
                       'subject' => 'Database errors at example.com',
                    ],
                ],*/
            ],
        ],
    ],
    'modules' => [
        # Yii2-User Extension
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true, // ไม่ต้องยืนยันการสมัครก็ล๊อกอินได้
            // 'enableConfirmation' => false, // true เปิด / false ปิด ระบบส่งอีเมลล์ ยืนยันการสมัครสมาชิก
            'confirmWithin' => 21600,
            'cost' => 12,
        //'admins' => ['admin']  // admin หมายถึง user ที่ถือสิทธิ์ Administration อยู่
        ],
    ],
    'params' => [
        'icon-framework' => 'fa', // Font Awesome Icon framework
    ]
];
