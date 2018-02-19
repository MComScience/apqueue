<?php
/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace msoft\menu\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    
    public $sourcePath = '@msoft/menu/assets';
    
    public $css = [
        'css/style.css',
    ];
    public $js = [
        //'multi_table.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
