<?php

namespace app\modules\api\modules\v1\controllers;

use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\AccessControl;
use yii\web\Response;

class QDataController extends \yii\rest\ActiveController
{
    public $modelClass = 'frontend\modules\main\models\TbCaller';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index'  => ['get'],
            ],
        ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['index'];
        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['?','@'],
                ],
            ],
        ];
        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => $this->modelClass::find(),
        ]);
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => (new \yii\db\Query())
            ->select(['tb_caller.*','tb_counterservice.*'])
            ->from('tb_caller')
            ->innerJoin('tb_counterservice','tb_counterservice.counterserviceid = tb_caller.counterserviceid'),
        ]);
    }

}
