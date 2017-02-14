<?php

namespace app\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\kiosk\models\TbQuequ;

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
                    'qserive1' => $qservice1,
                    'qserive2' => $qservice2,
                    'qserive3' => $qservice3,
                ];
                return $arr;
            } elseif ($request->post('Events') == 'ByConfirm') {
                $serviceid = $request->post('serviceid');
                $q_printstationid = 1;
                $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:q_printstationid) AS Qnum;')
                        ->bindParam(':userid', $userid)
                        ->bindParam(':serviceid', $serviceid)
                        ->bindParam(':q_printstationid', $q_printstationid)
                        ->queryScalar();
                return $Qnum;
            }
        }
    }

}
