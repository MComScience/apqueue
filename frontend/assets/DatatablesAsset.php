<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DatatablesAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/datatables.net-bs/css/dataTables.bootstrap.min.css?v=1.0',
        'vendor/DataTables-1.10.12/Responsive/css/responsive.bootstrap.min.css?v=1.0',
    ];
    public $js = [
        'vendor/datatables/media/js/jquery.dataTables.min.js?v=1.0',
        'vendor/datatables.net-bs/js/dataTables.bootstrap.min.js?v=1.0',
        'vendor/DataTables-1.10.12/Responsive/js/dataTables.responsive.min.js?v=1.0',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
