<?php

namespace app\modules\menu\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MenuAsset extends AssetBundle {

    public $sourcePath = '@app/modules/menu/assets/';
    public $css = [
        //'css/nestable.css',
        'toastr/build/toastr.min.css'
    ];
    public $js = [
        'js/jquery.nestable.js',
        //'js/config.js',
        'toastr/build/toastr.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
