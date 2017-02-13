<?php

namespace app\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

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

    public function actionGetQnumKiosk1() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $serviceid = $request->post('serviceid');
            $servicegroupid = $request->post('servicegroupid');
            $Qnum = Yii::$app->db->createCommand('SELECT func_ticket_create(:userid,:serviceid,:servicegroupid) AS Qnum;')
                    ->bindParam(':userid', Yii::$app->user->getId())
                    ->bindParam(':serviceid', $serviceid)
                    ->bindParam(':servicegroupid', $servicegroupid)
                    ->queryScalar();
            return $Qnum;
        }
    }

}
