<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SweetAlertAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'vendor/sweetalert/lib/sweet-alert.css'
        //'vendor/sweetalert-master/dist/sweetalert.css'
        'vendor/sweetalert2/dist/sweetalert2.min.css'
    ];
    public $js = [
        'vendor/sweetalert2/dist/sweetalert2.min.js',
        //'vendor/sweetalert/lib/sweet-alert.min.js',
        //'vendor/sweetalert-master/dist/sweetalert.min.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
