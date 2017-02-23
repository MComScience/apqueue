<?php

namespace app\modules\menu\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `menuconfig` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $mainlist = $this->getMainmenu();
        $backendlist = $this->getBackendManu();
        return $this->render('index',['mainlist' => $mainlist,'backendlist' => $backendlist]);
    }

    function actionSaveondrag() {
        $list = Yii::$app->getRequest()->post('list');
        $this->saveList($list);
    }

    private function Savelist($list, $parent_id = 0, $sort = 0) {
        $connection = \Yii::$app->db;
        foreach ($list as $item) {
            $sort++;
            $sql = "UPDATE menu SET parent_id = :parent_id,sort = :sort WHERE id = :id
        ";
            $user = $connection->createCommand($sql);
            $user->bindValue(":parent_id", $parent_id);
            $user->bindValue(":id", $item["id"]);
            $user->bindValue(":sort", $sort);
            $user->query();
            if (array_key_exists("children", $item)) {
                $this->Savelist($item["children"], $item["id"], $sort);
            }
        }
    }
    
    function getMainmenu($parent_id = 0) {
        $sql = "SELECT id, parent_id,title,icon,router FROM menu WHERE parent_id = " . $parent_id . " and menu_category_id = 2
        ORDER BY sort";
        $connection = \Yii::$app->db;
        $comman = $connection->createCommand($sql);
        $model = $comman->queryAll();
        foreach ($model as &$value) {
            $subresult = $this->getMainmenu($value["id"]);
            if (count($subresult) > 0) {
                $value['children'] = $subresult;
            }
        }
        unset($value);
        return $model;
    }
    
    function getBackendManu($parent_id = 0) {
        $sql = "SELECT id, parent_id,title,icon,router FROM menu WHERE parent_id = " . $parent_id . " and menu_category_id = 1
        ORDER BY sort";
        $connection = \Yii::$app->db;
        $comman = $connection->createCommand($sql);
        $model = $comman->queryAll();
        foreach ($model as &$value) {
            $subresult = $this->getBackendManu($value["id"]);
            if (count($subresult) > 0) {
                $value['children'] = $subresult;
            }
        }
        unset($value);
        return $model;
    }
    public function actionWidgets(){
        return $this->render('widgets');
    }

}
