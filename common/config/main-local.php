<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.getenv('HOST').';port='.getenv('MYSQL_PORT').';dbname='.getenv('MYSQL_DATABASE'),
            'username' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'charset' => 'utf8',
            'enableQueryCache' => true
        ],
        /*
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=db;port=3306;dbname=apqueue_ddc',
            'username' => 'Andaman',
            'password' => 'b8888888',
            'charset' => 'utf8',
            'enableQueryCache' => true
        ],*/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'thaiYearformat' => [
            'class' => 'common\components\ThaiYearFormat',
        ],
    ],
];
