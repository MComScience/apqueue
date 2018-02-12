<?php

namespace app\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\kiosk\models\TbQuequ;
use frontend\modules\kiosk\models\TbQueueorderdetail;
use yii\helpers\Html;
use frontend\modules\settings\models\TbDisplayConfig;
use frontend\modules\main\models\TbCaller;
use yii\helpers\ArrayHelper;
use frontend\modules\kiosk\models\VwDisplayService2;
use frontend\modules\main\classes\MainQuery;
use frontend\modules\kiosk\models\TbPrintlimit;
use frontend\modules\kiosk\models\TbService;
use common\components\AutoNumber;
use yii\helpers\Json;
/**
 * Default controller for the `kiosk` module
 */
class DefaultController extends Controller {
    
    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($action->id == 'display1' || $action->id == 'display2') {
            $this->layout = '@frontend/themes/homer/layouts/display.php';
        }

        return true;
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionExmroom() {
        return $this->render('exmroom');
    }
     public function actionExaminationroom() {
        return $this->render('examinationroom');
    }

    public function actionDisplay1() {
        $model = TbDisplayConfig::findOne(1);
        return $this->render('display1',['model' => $model]);
    }
    
    public function actionDisplay2() {
        $model = TbDisplayConfig::findOne(2);
        return $this->render('display2',['model' => $model]);
    }

    public function actionGetQnum() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $userid = Yii::$app->user->getId();
            $q_printstationid = $request->post('action') == 'index' ? 1 : 2;

            if ($request->post('Events') == 'Autoload') {
                return $this->getQCount();
            } elseif ($request->post('Events') == 'ByConfirm') {
                $serviceid = $request->post('serviceid');
                $servicegroupid = 1;
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $modelService = TbService::findOne($serviceid);
                    $maxids = TbQuequ::find()->where(['serviceid' => $serviceid])->max('q_ids');
                    if($maxids){
                        $model = TbQuequ::findOne($maxids);
                        $q  = $model['q_num'];
                    }else{
                        $q = null;
                    }
                    $auto = \Yii::createObject([
                        'class' => AutoNumber::className(),
                        'prefix' => $modelService['service_prefix'],
                        'number' => $q,
                        'digit' => $modelService['service_numdigit']
                    ]);
                    $q_num = $auto->generate();
                    $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid,:q_num) AS Qnum;')
                    ->bindParam(':userid', $userid)
                    ->bindParam(':serviceid', $serviceid)
                    ->bindParam(':q_printstationid', $q_printstationid)
                    ->bindParam(':servicegroupid', $servicegroupid)
                    ->bindParam(':q_num', $q_num)
                    ->queryScalar();

                    $printLimit = TbPrintlimit::findOne(['q_printstationid' => $q_printstationid]);
                    if($printLimit && $modelService){
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $printLimit['q_count'] + $modelService['prn_copyqty'];
                    }else{
                        $printLimit = new TbPrintlimit();
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $modelService['prn_copyqty'];
                    }
                    $printLimit->save(false);

                    $transaction->commit();
                    return $this->getQCount($printLimit);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } elseif ($request->post('Events') == 'PrintWithoutOrder') {
                $serviceid = $request->post('serviceid');
                $servicegroupid = 2;
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $modelService = TbService::findOne($serviceid);
                    $maxids = TbQuequ::find()->where(['serviceid' => $serviceid])->max('q_ids');
                    if($maxids){
                        $model = TbQuequ::findOne($maxids);
                        $q  = $model['q_num'];
                    }else{
                        $q = null;
                    }
                    $auto = \Yii::createObject([
                        'class' => AutoNumber::className(),
                        'prefix' => $modelService['service_prefix'],
                        'number' => $q,
                        'digit' => $modelService['service_numdigit']
                    ]);
                    $q_num = $auto->generate();
                    $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid,:q_num) AS Qnum;')
                    ->bindParam(':userid', $userid)
                    ->bindParam(':serviceid', $serviceid)
                    ->bindParam(':q_printstationid', $q_printstationid)
                    ->bindParam(':servicegroupid', $servicegroupid)
                    ->bindParam(':q_num', $q_num)
                    ->queryScalar();

                    $printLimit = TbPrintlimit::findOne(['q_printstationid' => $q_printstationid]);
                    if($printLimit && $modelService){
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $printLimit['q_count'] + $modelService['prn_copyqty'];
                    }else{
                        $printLimit = new TbPrintlimit();
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $modelService['prn_copyqty'];
                    }
                    $printLimit->save(false);

                    $transaction->commit();
                    return $this->getQCount($printLimit);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } elseif ($request->post('Events') == 'Print') {
                $serviceid = $request->post('serviceid');
                $servicegroupid = 2;
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $modelService = TbService::findOne($serviceid);
                    $maxids = TbQuequ::find()->where(['serviceid' => $serviceid])->max('q_ids');
                    if($maxids){
                        $model = TbQuequ::findOne($maxids);
                        $q  = $model['q_num'];
                    }else{
                        $q = null;
                    }
                    $auto = \Yii::createObject([
                        'class' => AutoNumber::className(),
                        'prefix' => $modelService['service_prefix'],
                        'number' => $q,
                        'digit' => $modelService['service_numdigit']
                    ]);
                    $q_num = $auto->generate();
                    $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid,:q_num) AS Qnum;')
                    ->bindParam(':userid', $userid)
                    ->bindParam(':serviceid', $serviceid)
                    ->bindParam(':q_printstationid', $q_printstationid)
                    ->bindParam(':servicegroupid', $servicegroupid)
                    ->bindParam(':q_num', $q_num)
                    ->queryScalar();

                    $printLimit = TbPrintlimit::findOne(['q_printstationid' => $q_printstationid]);
                    if($printLimit && $modelService){
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $printLimit['q_count'] + $modelService['prn_copyqty'];
                    }else{
                        $printLimit = new TbPrintlimit();
                        $printLimit->q_printstationid = $q_printstationid;
                        $printLimit->q_count = $modelService['prn_copyqty'];
                    }
                    $printLimit->save(false);

                    $transaction->commit();
                    return $this->getQCount($printLimit);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } elseif ($request->post('Events') == 'EXRoomAutoload') {
                return $this->getQCount();
            }
        }
    }

    public function actionSaveOrderdetail() {
        $qids = TbQuequ::find()->max('q_ids');
        $now = date('Y-m-d');
        if (isset($_POST['orderids'])) {
            foreach ($_POST['orderids'] as $data) {
                $model = new TbQueueorderdetail();
                $model->q_ids = $qids;
                $model->orderdetailid = $data;
                $model->q_result_tsp = $now;
                $model->save();
            }
        }
        return 'Success';
    }

    public function actionTableDisplay() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $servicegroupid = $request->post('ServiceName')  == 'คัดกรองผู้ป่วยนอก' ? 1 : 2;
            $postdata = $request->post('data',[]);
            if($servicegroupid == 1){
                $rows = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        //'GROUP_CONCAT(tb_caller.qnum) AS qnum',
                        'tb_caller.counterserviceid',
                        'tb_caller.call_timestp',
                        'tb_counterservice.counterservice_name',
                        'tb_counterservice.counterservice_callnumber'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => $servicegroupid,'tb_quequ.q_statusid' => 2])
                    ->andWhere("tb_caller.call_status <> 'Finished'")
                    ->orderBy('tb_caller.call_timestp DESC')
                    //->groupBy('tb_counterservice.counterservice_callnumber')
                    ->limit('5')
                    ->all();
            }else{
                if(isset($postdata['counternumber'])){
                    $array1 = (new \yii\db\Query())
                        ->select(['tb_caller.caller_ids', 'tb_caller.qnum', 'tb_caller.call_timestp','tb_counterservice.counterservice_callnumber'])
                        ->from('tb_caller')
                        ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                        ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                        ->where(['<>' ,'tb_caller.call_status','Finished'])
                        ->andWhere(['tb_quequ.servicegroupid' => 2,'tb_counterservice.counterservice_callnumber' => isset($postdata['counternumber']) ? $postdata['counternumber'] :[]])
                        ->orderBy('tb_caller.call_timestp ASC')
                        ->all();
                    $callerids = ArrayHelper::getColumn($array1, 'caller_ids');
                    $array2 = (new \yii\db\Query())
                            ->select([
                                'GROUP_CONCAT(tb_caller.qnum) AS qnum',
                                'tb_counterservice.counterservice_callnumber'
                            ])
                            ->from('tb_caller')
                            ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                            ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                            ->where(['tb_quequ.servicegroupid' =>2,'tb_quequ.q_statusid' => 2])
                            ->andWhere("tb_caller.call_status <> 'Finished'")
                            ->andWhere(['NOT IN', 'tb_caller.caller_ids',  $callerids])
                            ->orderBy('tb_caller.call_timestp DESC')
                            ->groupBy('tb_counterservice.counterservice_callnumber')
                            ->limit(4)
                            ->all();
                    $qnums = ArrayHelper::getColumn($array1, 'qnum');
                    $datas = ArrayHelper::merge(['qnum' => implode(',',$qnums)], ['counterservice_callnumber' => isset($postdata['counternumber']) ? $postdata['counternumber'] :[]]);
                    $rows = ArrayHelper::merge([$datas], $array2);
                }else{
                    $rows = (new \yii\db\Query())
                        ->select([
                            'GROUP_CONCAT(tb_caller.qnum) AS qnum',
                            'tb_counterservice.counterservice_callnumber'
                        ])
                        ->from('tb_caller')
                        ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                        //->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                        ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                        ->where(['tb_quequ.servicegroupid' => $servicegroupid,'tb_quequ.q_statusid' => 2])
                        ->andWhere("tb_caller.call_status <> 'Finished'")
                        //->andWhere(['NOT IN', 'tb_caller.caller_ids', isset($postdata['caller_ids']) ? $postdata['caller_ids'] : []])
                        ->orderBy('tb_caller.call_timestp DESC')
                        ->groupBy('tb_counterservice.counterservice_callnumber')
                        ->limit('5')
                        ->all();
                }
                
            }
            
            /*$rows = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        'tb_caller.counterserviceid',
                        'tb_caller.call_timestp',
                        'tb_counterservice.counterservice_name',
                        'tb_counterservice.counterservice_callnumber'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => $servicegroupid,'tb_quequ.q_statusid' => 2])
                    ->andWhere("tb_caller.call_status <> 'Finished'")
                    ->orderBy('tb_caller.call_timestp DESC')
                    ->limit('5')
                    ->all();
            $count = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        'tb_caller.call_timestp',
                        'tb_caller.counterserviceid',
                        'tb_counterservice.counterservice_name'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => $servicegroupid,'tb_quequ.q_statusid' => 2])
                    ->orderBy('tb_caller.call_timestp DESC')
                    ->limit('5')
                    ->count();*/
            $count = count($rows);
            $table = Html::beginTag('table', ['id' => 'table-display', 'width' => '100%', 'border' => 1, 'class' => 'table table-bordered',])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'หมายเลข', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
                    . Html::tag('th', 'ช่อง', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', ['id' => 'tbody-tabledisplay']);
            $i = 1;
            $config = $this->getStyleTable($request->post('ServiceName'));
            $styleth = 'font-size:' . $config['font_size'] . ';color:' . $config['font_color'] . ';background-color:' . $config['header_color'] . ';text-align: center;border-radius: 15px;border: 5px solid white;padding: 5px;';
            $styletbody = 'font-size:' . $config['font_size'] . ';color:' . $config['font_color'] . ';background-color:' . $config['column_color'] . ';text-align: center;border-radius: 15px;border: 5px solid white;padding: 5px;';
            if ($count == 0) {
                $table = Html::beginTag('table', ['id' => 'table-display', 'width' => '100%', 'class' => 'table table-responsive',])
                        . Html::beginTag('thead', ['style' => 'border-bottom: 5px solid ' . $config['bg_color'] . ';'])
                        . Html::tag('th', '<p style="' . $styleth . '"><strong class="col-md-6">' . $config['title_left'] . '</strong><strong>' . $config['title_right'] . '</strong></p>', ['style' => 'padding:0px;'])
                        . Html::endTag('thead')
                        . Html::beginTag('tbody', ['id' => 'tbody-tabledisplay']);
                for ($x = 1; $x <= $config['limit']; $x++) {
                    $table .= Html::beginTag('tr', ['class' => 'default']) .
                            Html::tag('td', '<p style="' . $styletbody . '"><strong class="col-md-6">-</strong><strong>-</strong></p>', ['style' => 'padding:0px;border-top: 0px;']) .
                            Html::endTag('tr');
                }
            } else {
                if(isset($postdata['counternumber'])){
                    $counternumber = $postdata['counternumber'];
                }else{
                    $counternumber = 0;
                }
                
                $table = Html::beginTag('table', ['id' => 'table-display', 'width' => '100%', 'class' => 'table table-responsive'])
                        . Html::beginTag('thead', ['style' => 'border-bottom: 5px solid ' . $config['bg_color'] . ';'])
                        . Html::tag('th', '<p style="' . $styleth . '"><strong class="col-sm-6">' . $config['title_left'] . '</strong><strong>' . $config['title_right'] . '</strong></p>', ['style' => 'padding:0px;'])
                        . Html::endTag('thead')
                        . Html::beginTag('tbody', ['id' => 'tbody-tabledisplay']);
                foreach ($rows as $result) {
                    $counternumber = ($counternumber == $result['counterservice_callnumber']) ? $counternumber : '0';
                    $table .= Html::beginTag('tr', ['id' => 'tr-' . str_replace(',','-',$result['qnum']), 'class' => 'default']) .
                            Html::tag('td', '<p style="' . $styletbody . '"><strong class="col-sm-6 service'.$counternumber.'" id="Qnum-' . str_replace(',','-',$result['qnum']) . '">' . $result['qnum'] . '</strong><strong class="service'.$counternumber.'" id="Counter-' . str_replace(',','-',$result['qnum']) . '">' . $result['counterservice_callnumber'] . '</strong></p>', ['style' => 'padding:0px;border-top: 0px;']) .
                            Html::endTag('tr');
                    if ($i == $count) {
                        for ($x = 1; $x <= ($config['limit'] - $count); $x++) {
                            $table .= Html::beginTag('tr', ['class' => 'default']) .
                                    Html::tag('td', '<p style="' . $styletbody . '"><strong class="col-sm-6">-</strong><strong>-</strong></p>', ['style' => 'padding:0px;border-top: 0px;']) .
                                    Html::endTag('tr');
                        }
                    }
                    $i++;
                }
            }

            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return ['table' => $table];
        }
    }
    
    public function actionTableDisplay2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $rows = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        'tb_caller.counterserviceid',
                        'tb_counterservice.counterservice_name'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => '2','tb_quequ.q_statusid' => 2])
                    ->orderBy('tb_caller.caller_ids DESC')
                    ->limit('5')
                    ->all();
            $count = (new \yii\db\Query())
                    ->select([
                        'tb_caller.caller_ids',
                        'tb_caller.qnum',
                        'tb_caller.counterserviceid'
                    ])
                    ->from('tb_caller')
                    ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                    ->innerJoin('tb_service', 'tb_quequ.serviceid = tb_service.serviceid')
                    ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                    ->where(['tb_quequ.servicegroupid' => '2','tb_quequ.q_statusid' => 2])
                    ->orderBy('tb_caller.caller_ids DESC')
                    ->limit('5')
                    ->count();
            $table = Html::beginTag('table', ['id' => 'table-display', 'width' => '100%', 'border' => 1, 'class' => 'table table-bordered',])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'หมายเลข', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
                    . Html::tag('th', 'ห้อง', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
                    . Html::endTag('thead')
                    . Html::beginTag('tbody', ['id' => 'tbody-tabledisplay']);
            $i = 1;
            if ($count == 0) {
                for ($x = 1; $x <= 5; $x++) {
                    $table .= Html::beginTag('tr', ['class' => 'default']) .
                            Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                            Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                            Html::endTag('tr');
                }
            } else {
                foreach ($rows as $result) {
                    $table .= Html::beginTag('tr', ['id' => 'tr-' . $result['qnum'], 'class' => 'default']) .
                            Html::tag('td', '<strong id="Qnum-' . $result['qnum'] . '" style="color:rgb(98, 203, 49)">' . $result['qnum'] . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                            Html::tag('td', '<strong id="Counter-' . $result['qnum'] . '" style="color:rgb(98, 203, 49)">' . $result['counterservice_name'] . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                            Html::endTag('tr');
                    if ($count == 1 && $i == 1) {
                        for ($x = 1; $x <= 4; $x++) {
                            $table .= Html::beginTag('tr', ['class' => 'default']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::endTag('tr');
                        }
                    }
                    if ($count == 2 && $i == 2) {
                        for ($x = 1; $x <= 3; $x++) {
                            $table .= Html::beginTag('tr', ['class' => 'default']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::endTag('tr');
                        }
                    }
                    if ($count == 3 && $i == 3) {
                        for ($x = 1; $x <= 2; $x++) {
                            $table .= Html::beginTag('tr', ['class' => 'default']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::endTag('tr');
                        }
                    }
                    if ($count == 4 && $i == 4) {
                        for ($x = 1; $x <= 1; $x++) {
                            $table .= Html::beginTag('tr', ['class' => 'default']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::tag('td', '<strong style="color:rgb(98, 203, 49)">' . '-' . '</strong>', ['style' => 'font-size: 30pt;text-align: center;border: 1px solid #62cb31;', 'width' => '300px', 'height' => '100px']) .
                                    Html::endTag('tr');
                        }
                    }
                    $i++;
                }
            }

            $table .= Html::endTag('tbody');
            $table .= Html::endTag('table');
            return $table;
        }
    }

    public function actionQueryQHold() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (($tbconfig = TbDisplayConfig::findOne(['display_name' => $request->post('display_name')])) != null) {
                if (!empty($tbconfig['hold_query'])) {
                    $result = Yii::$app->db->createCommand($tbconfig['hold_query'])
                            ->queryScalar();
                    return empty($result) ? false : $result;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }
    }

    static function getStyleTable($display_name) {
        if (($config = TbDisplayConfig::findOne(['display_name' => $display_name])) != null) {
            return $config;
        } else {
            return [
                'font_size' => '40pt',
                'font_color' => 'rgb(255, 255, 255)',
                'header_color' => 'rgb(0, 0, 0)',
                'column_color' => 'rgb(0, 0, 0)',
                'bg_color' => 'rgb(7, 55, 99)',
                'text-align' => 'center',
                'border-radius' => '15px',
                'border' => '5px solid white',
                'padding' => '5px',
                'limit' => 3
            ];
        }
    }

    static function getQCount($printLimit = null){
        $dataService1 = TbQuequ::find()
        ->where([
            'NOT IN' ,'tb_quequ.q_statusid',[1,4]
        ])
        ->andWhere([
            'tb_quequ.servicegroupid' => 1
        ])
        ->leftJoin('tb_caller','tb_caller.q_ids = tb_quequ.q_ids')
        ->groupBy('tb_quequ.q_ids')
        ->all();

        $dataService2 = TbQuequ::find()
        ->where([
            'NOT IN' ,'tb_quequ.q_statusid',[1,4]
        ])
        ->andWhere([
            'tb_quequ.servicegroupid' => 2
        ])
        ->leftJoin('tb_caller','tb_caller.q_ids = tb_quequ.q_ids')
        ->groupBy('tb_quequ.q_ids')
        ->all();

        $qservideGroup2 = MainQuery::qServiceGroup2();
        $servicewait = ArrayHelper::index($qservideGroup2['qwait'], null, 'serviceid');
        $serviceall = ArrayHelper::index($qservideGroup2['qall'], null, 'serviceid');
        $qcount = [];
        if(is_array($serviceall)){
            foreach($serviceall as $key => $item){
                $qcount[$key] = '<strong>' . (isset($servicewait[$key]) ? count($servicewait[$key]) : 0) . '/' . count($item) . '</strong><p style="line-height: 0.9;"><strong>คิว</strong></p>';
            }
        }
        
        $s1 = ArrayHelper::index($dataService1, null, 'serviceid');
        $alert = 'false';
        if(isset($printLimit) && ($printLimit['q_count'] == $printLimit['q_limitqty'] || $printLimit['q_count'] > $printLimit['q_limitqty'])){
            $alert = 'true';
        }
        //$qservice1 = TbQuequ::find()->where(['serviceid' => 1, 'q_statusid' => 12])->count('q_qty');
        //$qservice2 = TbQuequ::find()->where(['serviceid' => 2, 'q_statusid' => 12])->count('q_qty');
        //$qservice3 = TbQuequ::find()->where(['serviceid' => 3, 'q_statusid' => 12])->count('q_qty');
        $arr = [
            'qserive1' => isset($s1[1]) ? count($s1[1]) : 0,
            'qserive2' => isset($s1[2]) ? count($s1[2]) : 0,
            'qserive3' => isset($s1[3]) ? count($s1[3]) : 0,
            'dataService1' => $dataService1,
            'dataService2' => $dataService2,
            'qcount' => $qcount,
            'alert' => $alert
        ];
        return $arr;
    }

}
