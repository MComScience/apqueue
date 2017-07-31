<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ToastrAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/toastr/build/toastr.min.css',
    ];
    public $js = [
        'vendor/toastr/build/toastr.min.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}