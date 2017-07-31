<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'vendor/jPlayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css'
    ];
    public $js = [
        'js/smoothscroll.js?v=1.0',
        'vendor/jPlayer/dist/jplayer/jquery.jplayer.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
