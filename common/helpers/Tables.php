<?php 
namespace common\helpers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Tables extends Widget 
{
    public $options = [];

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        echo Tables::beginTable($this->options);
        echo $content;
        echo Tables::endTable();
    }

    public static function beginTable($options = []){
        $table = Html::beginTag('table', $options);
        return $table;
    }

    public static function endTable()
    {
        return '</table>';
    }

    public static function thead($options = [],$content = [])
    {
        $thead = Html::beginTag('thead', $options);
        $thead .= Html::beginTag('tr',[]);
        foreach($content as $th){
            $thead .= Html::tag('th',$th['label'],$th['options']);
        }
        $thead .= Html::endTag('tr');
        $thead .= Html::endTag('thead');
        return $thead;
    }
    
    public static function tbody($options = [],$content = [])
    {
        $thead = Html::beginTag('tbody', $options);
        $thead .= Html::beginTag('tr',[]);
        foreach($content as $th){
            $thead .= Html::tag('td',$th['label'],$th['options']);
        }
        $thead .= Html::endTag('tr');
        return $thead;
    }

    public static function beginBody($options = [])
    {
        $tbody = Html::beginTag('tbody', $options);
        return $tbody;
    }

    public static function endBody()
    {
        $endbody = Html::endTag('tbody');
        return $endbody;
    }

    public static function endThead()
    {
        $endthead = Html::endTag('thead');
        return $endthead;
    }
}
?>