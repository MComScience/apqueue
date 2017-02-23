<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TourAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/bootstrap-tour/build/css/bootstrap-tour.min.css',
    ];
    public $js = [
        'vendor/bootstrap-tour/build/js/bootstrap-tour.min.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
