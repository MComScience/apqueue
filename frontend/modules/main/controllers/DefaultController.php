<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\kiosk\models\TbQuequ;
use yii\web\Response;
use yii\helpers\Html;

/**
 * Default controller for the `main` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionTablecalling() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        'tb_service.service_name',
                        'tb_caller.counterserviceid',
                        'tb_caller.callerid',
                        'tb_caller.call_timestp',
                        'tb_caller.call_status',
                        'tb_caller.q_ids',
                        'tb_quequ.q_statusid',
                        'tb_counterservice.counterservice_name'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => $request->post('ServiceGroupID')])
                    ->andWhere('tb_quequ.q_statusid in (1,2,3)')
                    ->orderBy('tb_caller.caller_ids DESC')
                    ->all();
            $tabel = '<table class="table table-striped" id="table-calling"> 
                        <thead>
                            <tr>
                                <th style="font-size: 10pt; text-align: center;">QNum</th>
                                <th style="font-size: 10pt; text-align: center;">Service Name</th>
                                <th style="font-size: 10pt; text-align: center;">Counter Number</th>
                                <th style="font-size: 10pt; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($rows as $result) {
                $tabel .= '<tr>';
                $tabel .= '<td style="font-size:16pt; text-align: center;">' . $result['qnum'] . '</td>';
                $tabel .= '<td style="font-size:16pt; text-align: center;">' . $result['service_name'] . '</td>';
                $tabel .= '<td style="font-size:16pt; text-align: center;">' . $result['counterservice_name'] . '</td>';
                $tabel .= '<td style="text-align: center;white-space: nowrap ">';
                $tabel .= Html::a('Recall', FALSE, ['class' => 'btn btn-primary2 btn-sm', 'onclick' => 'Recall(' . $result['caller_ids'] . ')']) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'Hold(' . $result['q_ids'] . ')']) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(' . $result ['q_ids'] . ')']) . ' '
                        . Html::a('End', FALSE, ['class' => 'btn btn-success btn-sm', 'onclick' => 'End(' . $result['q_ids'] . ')']);
                $tabel .= '</td>';
                $tabel .= '</tr>';
            }
            $tabel .= '</tbody></tabel>';
            return $tabel;
        }
    }

    public function actionTablewaiting() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = (new \yii\db\Query())
                    ->select(['tb_quequ.q_num', 'tb_service.service_name', 'tb_quequ.serviceid', 'tb_quequ.q_ids', 'tb_quequ.servicegroupid'])
                    ->from('tb_quequ')
                    ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                    ->innerJoin('tb_qstatus', 'tb_qstatus.q_statusid = tb_quequ.q_statusid')
                    ->leftJoin('tb_caller', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->where(['tb_quequ.servicegroupid' => $request->post('ServiceGroupID'), 'tb_quequ.q_statusid' => '1'])
                    ->andWhere('isnull (tb_caller.qnum)')
                    ->all();
            $tabel = '<table class="table table-striped" id="table-waiting"> 
                    <thead>
                        <tr>
                            <th style="font-size: 10pt; text-align: center;">
                                QNum
                            </th>
                            <th style="font-size: 10pt; text-align: center;">
                                Service Name
                            </th>
                            <th style="font-size: 10pt; text-align: center;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($rows as $result) {
                $tabel .= '<tr>';
                $tabel .= '<td style="font-size:16pt; text-align: center;">' . $result['q_num'] . '</td>';
                $tabel .= '<td style="font-size:16pt; text-align: center;">' . $result['service_name'] . '</td>';
                $tabel .= '<td style="text-align: center;white-space: nowrap">'
                        . Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'Callq(this)', 'data-id' => $result['q_num']]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'hold(' . $result['q_ids'] . ')']) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(' . $result['q_ids'] . ')']) .
                        '</td>';
                $tabel .= '</tr>';
            }
            $tabel .= '</tbody></tabel>';
            return $tabel;
        }
    }

}
