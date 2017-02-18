<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\kiosk\models\TbQuequ;
use yii\web\Response;
use yii\helpers\Html;
use frontend\modules\main\classes\MainQuery;
use frontend\modules\main\models\TbCaller;

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
                $Caller = new TbCaller();
                $Caller->caller_ids = ($callserids + 1);
                $Caller->qnum = $TbQ['q_num'];
                $Caller->counterserviceid = empty($request->post('Counter1')) ? $request->post('Counter2') : $request->post('Counter1');
                $Caller->callerid = Yii::$app->user->getId();
                $Caller->call_timestp = date('Y-m-d H:i:s');
                $Caller->call_status = 'calling';
                $Caller->q_ids = $TbQ['q_ids'];
                $Caller->save();

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
            return 'Recall Success!';
        }
    }
    
    public function actionEnd() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbQuequ::findOne($request->post('q_ids'));
            $model->q_statusid = 4;
            $model->save();
            return 'End Success!';
        }
    }

}
