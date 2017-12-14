<?php
namespace common\themes\homer\web;

use yii\base\Exception;
use yii\web\AssetBundle as BaseHomerAsset;

class HomerAsset extends BaseHomerAsset
{
    public $sourcePath = '@common/themes/homer/assets';
    public $css = [
        'vendor/fontawesome/css/font-awesome.css',
        'vendor/metisMenu/dist/metisMenu.css',
        'vendor/animate.css/animate.css',
        'fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'fonts/pe-icon-7-stroke/css/helper.css',
        'styles/style-new.css',
        'styles/static_custom.css'
        //'vendor/bootstrap/dist/css/bootstrap.css'
    ];
    public $js = [
        //'vendor/jquery/dist/jquery.min.js',
        'vendor/jquery-ui/jquery-ui.min.js',
        'vendor/slimScroll/jquery.slimscroll.min.js',
        'vendor/metisMenu/dist/metisMenu.min.js',
        'vendor/iCheck/icheck.min.js',
        'vendor/sparkline/index.js',
        'scripts/homer.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
