<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ICheckAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/iCheck/skins/all.css',
    ];
    public $js = [
        'vendor/iCheck/icheck.min.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
