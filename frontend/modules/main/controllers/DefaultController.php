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
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
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

    public function actionSound() {
        return $this->render('sound');
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
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-calling','width' => '100%'])
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
                $table .= Html::a('Recall', FALSE, ['class' => 'btn btn-primary2 btn-sm', 'onclick' => 'App.Recall(this);', 'data-id' => $result['caller_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'App.Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]) . ' '
                        . Html::a('End', FALSE, ['class' => 'btn btn-success btn-sm', 'onclick' => 'App.End(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['qnum']]);
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
            if($request->post('ServiceGroupID') == '2'){
                $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-waiting','width' => '100%'])
                        . Html::beginTag('thead', [])
                        . Html::tag('th', '', ['style' => 'font-size: 10pt; text-align: center;'])
                        . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                        . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                        . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                        . Html::endTag('thead')
                        . Html::beginTag('tbody', []);
                foreach ($rows as $result) {
                    $table .= Html::beginTag('tr', ['id' => 'tr-waiting' . $result['q_ids'],]);
                    $table .= Html::tag('td', '<div class="checkbox">'.Html::checkbox('checkbox', false, ['label' => '','value' => $result['q_ids'],'class' => 'icheckbox_square-green']).'</div>', ['style' => 'font-size:16pt; text-align: center;']);
                    $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                    $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                    $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                    $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'App.CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num'],'serviceid' => 0]) . ' '
                            . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'App.Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                            . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                    $table .= Html::endTag('td');
                    $table .= Html::endTag('tr');
                }
                $table .= Html::endTag('tbody');
                $table .= Html::endTag('table');
            }else{
                $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-waiting','width' => '100%'])
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
                    $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'App.CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num'],'serviceid' => 0]) . ' '
                            . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'App.Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                            . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
                    $table .= Html::endTag('td');
                    $table .= Html::endTag('tr');
                }
                $table .= Html::endTag('tbody');
                $table .= Html::endTag('table');
            }
            return $table;
        }
    }

    public function actionTableholdlist() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = MainQuery::getTableholdlist($request->post('ServiceGroupID'));
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-holdlist','width' => '100%'])
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
                $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'App.CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
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
                        Html::a('Recall', FALSE, ['class' => 'btn btn-primary2 btn-sm', 'onclick' => 'App.Recall(this);', 'data-id' => $calldata ['caller_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'App.Hold(this);', 'data-id' => $calldata ['q_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $calldata ['q_ids'], 'qnum' => $calldata['qnum']]) . ' ' .
                        Html::a('End', FALSE, ['class' => 'btn btn-success btn-sm', 'onclick' => 'App.End(' . $calldata['q_ids'] . ')']) .
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
                $table .= Html::a('Select', false, ['class' => 'btn btn-info btn-sm', 'onclick' => 'App.Select(this);', 'data-id' => $result['q_num']]) . ' '
                        . Html::a('Hold', false, ['class' => 'btn btn-primary btn-sm']) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
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
            $table = Html::beginTag('table', ['class' => 'table table-striped', 'id' => 'table-waitingorder','width' => '100%'])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'QNum', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Service Name', ['style' => 'font-size: 10pt; text-align: center;'])
                    //. Html::tag('th', 'ห้องตรวจ', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'รายการคำสั่ง', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::tag('th', 'Actions', ['style' => 'font-size: 10pt; text-align: center;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', []);
            foreach ($rows as $result) {
                $table .= Html::beginTag('tr', ['id' => 'tr-waitingoder' . $result['q_ids'],]);
                $table .= Html::tag('td', $result['q_num'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['service_name'], ['style' => 'font-size:16pt; text-align: center;']);
                //$table .= Html::tag('td', $result['servicegroup_name'], ['style' => 'font-size:16pt; text-align: center;']);
                $table .= Html::tag('td', $result['orderdetail'], ['style' => 'font-size:16pt; text-align: left;']);
                $table .= Html::beginTag('td', ['style' => 'text-align: center;white-space: nowrap']);
                $table .= Html::a('Call', FALSE, ['class' => 'btn btn-success  btn-sm', 'onclick' => 'App.CallButton(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Hold', FALSE, ['class' => 'btn btn-primary  btn-sm', 'onclick' => 'App.Hold(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]) . ' '
                        . Html::a('Delete', FALSE, ['class' => 'btn btn-danger btn-sm', 'onclick' => 'App.Delete(this);', 'data-id' => $result['q_ids'], 'qnum' => $result['q_num']]);
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
                return [
                    'status' => 'มีหมายเลขคิว',
                    'content' => $this->renderAjax('_form_counter')
                ];
            }
        }
    }

    public function actionGetQwaiting(){
        $request = Yii::$app->request;
        $model = new TbQuequ();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = TbQuequ::find()->orderBy('q_ids')->where(['q_statusid' => 12])->asArray()->all();
            if($request->isGet){
                $items = ArrayHelper::map($query, 'q_ids', 'q_num');
                return [
                    'title'=> "คิวรอเรียก",
                    'content'=>$this->renderAjax('_qwaiting', [
                        'model' => $model,
                        'items' => $items,
                    ]),
                    'footer'=> ''
        
                ];
            }
        }
    }

    public function actionGetSound(){
        $request = Yii::$app->request;
        if($request->isPost){
            $query = MainQuery::getSound($request->post('servicegroup'));
            if($query['group'] == 1){//เรียกคิวเดียว
                $qnum_str = str_split($query['rows']['qnum']);
                $prompt = isset($query['rows']['sound_typeid']) ? 'Prompt'.$query['rows']['sound_typeid'] : 'Prompt1';
                $basePath = Yii::getAlias('@web').'/sounds/'.$prompt.'/';

                $source = [];

                if(!empty($query['rows']['qnum']) && is_array($qnum_str)){
                    foreach($qnum_str as $str){
                        $source = ArrayHelper::merge($source, [$basePath.$prompt.'_'.$str.'.wav']);
                    }
                    $source = ArrayHelper::merge(["/sounds/".$prompt."/".$prompt."_Number.wav"], $source);
                    $source = ArrayHelper::merge($source,[
                        "/sounds/".$prompt."/".$prompt."_Service.wav",
                        "/sounds/".$prompt."/".$prompt."_".$query['counternumber'].".wav",
                        "/sounds/".$prompt."/".$prompt."_Sir.wav"
                    ]);

                    $data = [
                        'caller_ids' => $query['rows']['caller_ids'],
                        'source' => $source,
                        'qnum' => $query['rows']['qnum'],
                        'servicegroup' => $query['servicegroup'],
                        'counternumber' => $query['counternumber'],
                    ];
                    return Json::encode($data);
                }else{
                    return Json::encode("No sound!");
                }
            }else{//เรียกหลายคิว
                
                $source = [];
                $caller_ids = [];
                if($query['status'] != 'No data'){
                    $qnums = [];
                    $callerids = ArrayHelper::getValue($query['rows'],'caller_ids');
                    if(isset($query['rows'][0])){
                        $prompt = $query['rows'][0]['sound_typeid'] != null ? 'Prompt'.$query['rows'][0]['sound_typeid'] : 'Prompt1';
                    }else{
                        $prompt = isset($query['rows']['sound_typeid']) ? 'Prompt'.$query['rows']['sound_typeid'] : 'Prompt1';
                    }
                    $basePath = Yii::getAlias('@web').'/sounds/'.$prompt.'/';
                    if($callerids === null){
                        foreach($query['rows'] as $val){
                            $qnum_str = str_split($val['qnum']);
                            $caller_ids[] = $val['caller_ids'];
                            $qnums = ArrayHelper::merge($qnums,[$val['qnum']]);
                            foreach($qnum_str as $str){
                                $source = ArrayHelper::merge($source, [$basePath.$prompt.'_'.$str.'.wav']);
                            }
                        }
                        $source = ArrayHelper::merge(["/sounds/".$prompt."/".$prompt."_Number.wav"], $source);
                        $source = ArrayHelper::merge($source,[
                            "/sounds/".$prompt."/".$prompt."_Service.wav",
                            "/sounds/".$prompt."/".$prompt."_".$query['counternumber'].".wav",
                            "/sounds/".$prompt."/".$prompt."_Sir.wav"
                        ]);
                    }else{
                        $qnum_str = str_split($query['rows']['qnum']);
                        $caller_ids[] = $query['rows']['caller_ids'];
                        $qnums = ArrayHelper::merge($qnums,[$query['rows']['qnum']]);
                        foreach($qnum_str as $str){
                            $source = ArrayHelper::merge($source, [$basePath.$prompt.'_'.$str.'.wav']);
                        }
                        $source = ArrayHelper::merge(["/sounds/".$prompt."/".$prompt."_Number.wav"], $source);
                        $source = ArrayHelper::merge($source,[
                            "/sounds/".$prompt."/".$prompt."_Service.wav",
                            "/sounds/".$prompt."/".$prompt."_".$query['counternumber'].".wav",
                            "/sounds/".$prompt."/".$prompt."_Sir.wav"
                        ]);
                    }
                    
                    $data = [
                        'caller_ids' => $caller_ids,
                        'source' => $source,
                        'qnum' => implode(',',$qnums),
                        'servicegroup' => $query['servicegroup'],
                        'counternumber' => $query['counternumber'],
                    ];
                    return Json::encode($data);
                }else{
                    return Json::encode("No sound!");
                }
            } 
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateStatusCall(){
        $request = Yii::$app->request;
        if($request->isPost){
            if(is_array($request->post('caller_ids'))){
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach($request->post('caller_ids') as $ids){
                        $model = TbCaller::findOne($ids);
                        $model->call_status  = 'called';
                        //$model->call_timestp = date('Y-m-d H:i:s');
                        $model->save();
                    }
                    $transaction->commit();
                    return Json::encode('Update Success!');
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }else{
                $model = TbCaller::findOne($request->post('caller_ids'));
                $model->call_status  = 'called';
                //$model->call_timestp = date('Y-m-d H:i:s');
                if($model->save()){
                    return Json::encode('Update Success!');
                }else{
                    return Json::encode('Error!');
                }
            }
            
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCallMultiple() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            if(is_array($request->post('values'))){
                foreach($request->post('values') as $val){
                    $modelQ = TbQuequ::findOne($val);
                    $modelQ->q_statusid = 2;
                    $modelQ->save();
                    #
                    $callserids = TbCaller::find()->max('caller_ids');
                    $Caller = new TbCaller();
                    $Caller->caller_ids = ($callserids + 1);
                    $Caller->qnum = $modelQ['q_num'];
                    $Caller->counterserviceid = $request->post('counterid');
                    $Caller->callerid = Yii::$app->user->getId();
                    $Caller->call_timestp = date('Y-m-d H:i:s');
                    $Caller->call_status = 'calling';
                    $Caller->q_ids = $modelQ['q_ids'];
                    $Caller->save();
                }
                return 'Success!';
            }
        }
    }

    public function actionTestQuery(){
        $query = MainQuery::getSound(2);
        // $rows = (new \yii\db\Query())
        //     ->select(['tb_caller.caller_ids', 'tb_caller.qnum', 'tb_caller.call_timestp','tb_counterservice.counterservice_callnumber'])
        //     ->from('tb_caller')
        //     ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
        //     ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
        //     ->where(['<>' ,'tb_caller.call_status','Finished'])
        //     ->andWhere(['tb_quequ.servicegroupid' => 2,'tb_counterservice.counterservice_callnumber' => 10])
        //     ->orderBy('tb_caller.call_timestp ASC')
        //     ->all();
        // $callerids = ArrayHelper::getColumn($rows, 'caller_ids');
        // $array2 = (new \yii\db\Query())
        //         ->select([
        //             'GROUP_CONCAT(tb_caller.qnum) AS qnum',
        //             'tb_counterservice.counterservice_callnumber'
        //         ])
        //         ->from('tb_caller')
        //         ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
        //         ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
        //         ->where(['tb_quequ.servicegroupid' =>2,'tb_quequ.q_statusid' => 2])
        //         ->andWhere("tb_caller.call_status <> 'Finished'")
        //         ->andWhere(['NOT IN', 'tb_caller.caller_ids',  $callerids])
        //         ->orderBy('tb_caller.call_timestp DESC')
        //         ->groupBy('tb_counterservice.counterservice_callnumber')
        //         ->limit(4)
        //         ->all();
        // $qnums = ArrayHelper::getColumn($rows, 'qnum');
        // $array1 = ArrayHelper::merge(['qnum' => implode(',',$qnums)], ['counterservice_callnumber' => 10]);
        // $rowdata = ArrayHelper::merge([$array1], $array2);
        echo Json::encode($query);
    }

}
