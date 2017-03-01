<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\kiosk\models\TbQuequ;
use yii\web\Response;
use yii\helpers\Html;
use frontend\modules\main\classes\MainQuery;
use frontend\modules\main\models\TbCaller;
use frontend\modules\kiosk\models\TbOrderdetail;
use frontend\modules\kiosk\models\TbQueueorderdetail;

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

    public function actionOrderCheck() {

        return $this->render('order-check', [
        ]);
    }

    public function actionTablecalling() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getTablecalling($request->post('ServiceGroupID'));
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-calling'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Counter Number', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', ['id' => 'tbody-tablecalling']);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', ['id' => 'tr-' . $result['qnum'], 'class' => 'default']);
                $table .= Html::tag('td', $result['qnum'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['counterservice_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Recall', FALSE, ['class' => 'btn btn-primary2 btn-sm', 'onclick' => 'Recall(this);', 'data-id' => $result['caller_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('End', FALSE, ['class' => 'btn btn-success btn-sm', 'onclick' => 'End(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]);
                $table .= Html::endTag('td');
                $table .= Html::endTag('tr');
            }
            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionTablewaiting() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getTablewaiting($request->post('ServiceGroupID'));
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-waiting'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', []);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', ['id' => 'tr-waiting' . $result['q_ids'],]);
                $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num'],'serviceid' => 0]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                $table .= Html::endTag('td');
                $table .= Html::endTag('tr');
            }
            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionTableholdlist() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getTableholdlist($request->post('ServiceGroupID'));
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-holdlist'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', []);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', []);
                $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                $table .= Html::endTag('td');
                $table .= Html::endTag('tr');
            }
            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionCall() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (TbCaller::findAll(['qnum' => $request->post('QNumber')]) != null) {
                return 'เรียกซ้ำ';
            } elseif (TbQuequ::findAll(['q_num' => $request->post('QNumber')]) == null) {
                return 'ไม่มีหมายเลขคิว';
            } else {
                $TbQ = TbQuequ::findOne(['q_num' => $request->post('QNumber')]);
                $TbQ->q_statusid = 2;
                $TbQ->save();
                $callserids = TbCaller::find()->max('caller_ids');
                if (isset($_POST['counters'])) {
                    foreach ($_POST['counters'] as $value) {
                        $Caller = new TbCaller();
                        $Caller->caller_ids = ($callserids + 1);
                        $Caller->qnum = $TbQ['q_num'];
                        $Caller->counterserviceid = $value;
                        $Caller->callerid = Yii::$app->user->getId();
                        $Caller->call_timestp = date('Y-m-d H:i:s');
                        $Caller->call_status = 'calling';
                        $Caller->q_ids = $TbQ['q_ids'];
                        $Caller->save();
                    }
                }

                $calldata = MainQuery::getTablecallingOncall($TbQ['q_ids']);
                $rows = Html::beginTag('tr', ['id' => 'tr-' . $calldata['qnum'], 'class' => 'default']) .
                        Html::tag('td', $calldata['qnum'], ['style' => 'font-size:16pt; text-align: center;']) .
                        Html::tag('td', $calldata['service_name'], ['style' => 'font-size:16pt; text-align: center;']) .
                        Html::tag('td', $calldata['counterservice_name'], ['style' => 'font-size:16pt; text-align: center;']) .
                        Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']) .
                        Html::a('Recall', FALSE, ['class' => 'btn btn-primary2 btn-sm', 'onclick' => 'Recall(this);', 'data-id' => $calldata ['caller_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'Hold(this);', 'data-id' => $calldata ['q_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $calldata ['q_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('End', FALSE, ['class' => 'btn btn-success btn-sm', 'onclick' => 'End(' . $calldata['q_ids'] . ')']) .
                        Html::endTag('td') .
                        Html::endTag('tr');
                return $rows;
            }
        }
    }

    public function actionDelete() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            TbQuequ::findOne($request->post('q_ids'))->delete();
            if (($tbcaller = TbCaller::findOne(['q_ids' => $request->post('q_ids')])) != null) {
                $tbcaller->delete();
            }
            return 'Deleted!';
        }
    }

    public function actionHold() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbQuequ::findOne($request->post('q_ids'));
            $model->q_statusid = 3;
            $model->save();
            if (($tbcaller = TbCaller::findOne(['q_ids' => $request->post('q_ids')])) != null) {
                $tbcaller->delete();
            }
            return 'Hold Success!';
        }
    }

    public function actionRecall() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $caller = TbCaller::findOne($request->post('caller_ids'));
            $caller->call_timestp = date('Y-m-d H:i:s');
            $caller->call_status = 'calling';
            $caller->save();
            return $caller['qnum'];
        }
    }

    public function actionEnd() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbQuequ::findOne($request->post('q_ids'));
            $model->q_statusid = 4;
            $model->save();
            if (($tbcaller = TbCaller::findOne(['q_ids' => $request->post('q_ids')])) != null) {
                $tbcaller->call_status = 'Finished';
                $tbcaller->save();
            }
            return 'End Success!';
        }
    }

    public function actionGetOrderlist() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (($tbq = TbQuequ::findOne(['q_num' => $request->post('QNumber')])) == null) {
                return 'ไม่มีหมายเลขคิว';
            } else {
                $orderdetail = TbOrderdetail::find()->orderBy('orderdetailid ASC')->all();
                $form = $this->renderAjax('order-list', [
                    'orderdetail' => $orderdetail,
                    'q_ids' => $tbq['q_ids'],
                ]);
                return $form;
            }
        }
    }

    public function actionSaveOrderdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $orderids = [];
            if (isset($_POST['orderids'])) {
                foreach ($_POST['orderids'] as $data) {
                    if (($model = TbQueueorderdetail::findOne(['q_ids' => $request->post('q_ids'), 'orderdetailid' => $data])) != null) {
                        $model->q_result = 'Y';
                    } else {
                        $now = date('Y-m-d');
                        $model = new TbQueueorderdetail();
                        $model->q_ids = $request->post('q_ids');
                        $model->orderdetailid = $data;
                        $model->q_result_tsp = $now;
                        $model->q_result = 'Y';
                    }
                    $model->save();
                    $orderids[] = $data;
                }
                /*
                  $rows = (new \yii\db\Query())
                  ->select([
                  'tb_queueorderdetail.ids'
                  ])
                  ->from('tb_queueorderdetail')
                  ->where(['tb_queueorderdetail.q_ids' => $request->post('q_ids')])
                  ->andWhere(['not in', 'orderdetailid', $orderids])
                  ->all();
                  foreach ($rows as $d) {
                  TbQueueorderdetail::findOne($d['ids'])->delete();
                  } */
            } else {
                if (($model = TbQueueorderdetail::findOne(['q_ids' => $request->post('q_ids'), 'orderdetailid' => $request->post('orderid')])) != null) {
                    $model->q_result = null;
                    $model->save();
                }
                /*
                  if ((TbQueueorderdetail::findAll(['q_ids' => $request->post('q_ids')])) != null) {
                  TbQueueorderdetail::deleteAll(['q_ids' => $request->post('q_ids')]);
                  }
                 */
            }
            return 'Success!';
        }
    }

    public function actionTableOrdercheck() {

        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getOrderChecklist();
            $table = Html::beginTag('table', ['class' => 'table table-bordered table-striped', 'id' => 'table-ordercheck', 'width' => '100%'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 14pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 14pt; text-align: center;'])
                    . Html::tag('th', 'ห้องตรวจ', ['style' => 'font-size: 14pt; text-align: center;'])
                    . Html::tag('th', 'รายการคำสั่ง', ['style' => 'font-size: 14pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 14pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', []);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', []);
                $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['servicegroup_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['orderdetail'], ['style' => 'font-size:16pt; text-align: left;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Select', false, ['class' => 'btn btn-info btn-sm', 'onclick' => 'Select(this);', 'data-id' => $result['q_num']]) . ' '
                        . Html::a('Hold', false, ['class' => 'btn btn-primary btn-sm']) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                $table .= Html::endTag('td');
                $table .= Html::endTag('tr');
            }
            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionTablewaitingorder() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getTablewaitingorder();
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-waitingorder'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'ห้องตรวจ', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'รายการคำสั่ง', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', []);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', ['id' => 'tr-waitingoder' . $result['q_ids'],]);
                $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['servicegroup_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['orderdetail'], ['style' => 'font-size:16pt; text-align: left;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                $table .= Html::endTag('td');
                $table .= Html::endTag('tr');
            }
            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionCheckqnum() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ((TbQuequ::findAll(['q_num' => $request->post('QNumber')])) == null) {
                return 'ไม่มีหมายเลขคิว';
            } else {
                return 'มีหมายเลขคิว';
            }
        }
    }

}
