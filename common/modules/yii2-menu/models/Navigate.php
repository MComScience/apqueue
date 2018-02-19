<?php

namespace msoft\menu\models;

//use yii\base\Model;
use Yii;
use yii\helpers\Html;
use msoft\menu\models\Menu;

/**
 * Description of navigate
 *
 * @author madone
 */
class Navigate extends \yii\base\Model {

    //put your code here
    public function menu($category_id) {
        $model = Menu::find()
                ->where([
                    'menu_category_id' => $category_id,
                    'status' => '1',
                    'parent_id' => 0
                ])
                ->orderBy(['sort' => SORT_ASC])
                ->all();

        return $this->genArray($model);
    }

    public function parentMenu($id) {
        $model = Menu::find()
                ->where([
                    'parent_id' => $id,
                    'status' => '1'
                ])
                ->orderBy(['sort' => SORT_ASC])
                ->all();
        return $model ? $this->genArray($model) : null;
    }

    private function genArray($model) {
        //$ob='backend\modules\seller\models\RegisterSeller::getCoutRegis();';
        //$run ='getCoutRegis()';
        $menu = [];
        foreach ($model as $val) {
            $items = ($val->id) ? $this->parentMenu($val->id) : null;
            //$params = $val['params']?Json::encode($val['params']):null;
            //print_r($params);
            //$labelParam = $params?(eval('return '.$params['label'])):null;
            
            $visible = false;
            $menuAuths = $val->menuAuths; 
            foreach($menuAuths as $item){
                if($visible = Yii::$app->user->can($item->item_name)){
                    break;
                }
            }
            
            $this->getCount($val->router);
            $menu[] = [
                'label' => $val->title . $this->count,
                'encode' => false,
                'icon' => $val->icon,
                'url' => [$val->router],
                'visible' => $visible,
                //$visible,
                'items' => $items
            ];
        }
        //print_r($menu);
        return $menu;
    }   
    protected $count;
    protected function getCount($router){
        //return $count;
    }
    

}
