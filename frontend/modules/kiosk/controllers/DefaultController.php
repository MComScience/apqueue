<?php

namespace app\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\kiosk\models\TbQuequ;
use frontend\modules\kiosk\models\TbQueueorderdetail;

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

    public function actionGetQnum() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $userid = Yii::$app->user->getId();

            if ($request->post('Events') == 'Autoload') {
                $qservice1 = TbQuequ::find()->where(['serviceid' => 1, 'q_statusid' => 1])->max('q_qty');
                $qservice2 = TbQuequ::find()->where(['serviceid' => 2, 'q_statusid' => 1])->max('q_qty');
                $qservice3 = TbQuequ::find()->where(['serviceid' => 3, 'q_statusid' => 1])->max('q_qty');
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

}
