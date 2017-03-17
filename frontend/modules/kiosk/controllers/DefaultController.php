<?php

namespace app\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\kiosk\models\TbQuequ;
use frontend\modules\kiosk\models\TbQueueorderdetail;
use yii\helpers\Html;

/**
 * Default controller for the `kiosk` module
 */
class DefaultController extends Controller {
    

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

    public function actionDisplay1() {
        return $this->render('display1');
    }
    
    public function actionDisplay2() {
        return $this->render('display2');
    }

    public function actionGetQnum() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $userid = Yii::$app->user->getId();

            if ($request->post('Events') == 'Autoload') {
                $qservice1 = TbQuequ::find()->where(['serviceid' => 1, 'q_statusid' => 1])->count('q_qty');
                $qservice2 = TbQuequ::find()->where(['serviceid' => 2, 'q_statusid' => 1])->count('q_qty');
                $qservice3 = TbQuequ::find()->where(['serviceid' => 3, 'q_statusid' => 1])->count('q_qty');
                $arr = [
                    'qserive1' => $qservice1 == null ? 0 : $qservice1,
                    'qserive2' => $qservice2 == null ? 0 : $qservice2,
                    'qserive3' => $qservice3 == null ? 0 : $qservice3,
                ];
                return $arr;
            } elseif ($request->post('Events') == 'ByConfirm') {
                $serviceid = $request->post('serviceid');
                $q_printstationid = 1;
                $servicegroupid = 1;
                $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid) AS Qnum;')
                        ->bindParam(':userid', $userid)
                        ->bindParam(':serviceid', $serviceid)
                        ->bindParam(':q_printstationid', $q_printstationid)
                        ->bindParam(':servicegroupid', $servicegroupid)
                        ->queryScalar();
                return $Qnum;
            } elseif ($request->post('Events') == 'PrintWithoutOrder') {
                $serviceid = $request->post('serviceid');
                $q_printstationid = 1;
                $servicegroupid = 2;
                $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid) AS Qnum;')
                        ->bindParam(':userid', $userid)
                        ->bindParam(':serviceid', $serviceid)
                        ->bindParam(':q_printstationid', $q_printstationid)
                        ->bindParam(':servicegroupid', $servicegroupid)
                        ->queryScalar();
                $count = TbQuequ::find()->where(['serviceid' => $serviceid, 'q_statusid' => 1])->count('q_ids');
                return '<strong>' . $Qnum . '/' . $count . '</strong><p style="line-height: 0.9;"><strong>คิว</strong></p>';
            } elseif ($request->post('Events') == 'Print') {
                $serviceid = $request->post('serviceid');
                $q_printstationid = 1;
                $servicegroupid = 2;
                $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid,:servicegroupid) AS Qnum;')
                        ->bindParam(':userid', $userid)
                        ->bindParam(':serviceid', $serviceid)
                        ->bindParam(':q_printstationid', $q_printstationid)
                        ->bindParam(':servicegroupid', $servicegroupid)
                        ->queryScalar();
                $count = TbQuequ::find()->where(['serviceid' => $serviceid, 'q_statusid' => 1])->count('q_ids');
                $arr = [
                    'result' => '<strong>' . $Qnum . '/' . $count . '</strong><p style="line-height: 0.9;"><strong>คิว</strong></p>',
                    'qnum' => $Qnum
                ];
                return $arr;
            } elseif ($request->post('Events') == 'EXRoomAutoload') {
                $Qnum = TbQuequ::find()->where(['serviceid' => $request->post('serviceid'), 'q_statusid' => 1])->max('q_qty');
                $count = TbQuequ::find()->where(['serviceid' => $request->post('serviceid'), 'q_statusid' => 1])->count('q_ids');
                $num = $Qnum == null ? '0' : $Qnum;
                $arr = [
                    'result' => '<strong>' . $num . '/' . $count . '</strong><p style="line-height: 0.9;"><strong>คิว</strong></p>',
                    'serviceid' => $request->post('serviceid')
                ];
                return $arr;
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
                    ->where(['tb_quequ.servicegroupid' => '1','tb_quequ.q_statusid' => 2])
                    ->orderBy('tb_caller.caller_ids DESC')
                    ->limit('5')
                    ->all();
            $count = (new \yii\db\Query())
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
                    ->where(['tb_quequ.servicegroupid' => '1','tb_quequ.q_statusid' => 2])
                    ->orderBy('tb_caller.caller_ids DESC')
                    ->limit('5')
                    ->count();
            $table = Html::beginTag('table', ['id' => 'table-display', 'width' => '100%', 'border' => 1, 'class' => 'table table-bordered',])
                    . Html::beginTag('thead', [])
                    . Html::tag('th', 'หมายเลข', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
                    . Html::tag('th', 'ช่อง', ['style' => 'font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid #62cb31;color: white;width: 300px;height: 100px;'])
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

}
