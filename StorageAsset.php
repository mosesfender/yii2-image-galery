<?php

namespace mosesfender\galery;

use yii\web\AssetBundle;

class StorageAsset extends AssetBundle {

    public $sourcePath = '@mosesfender/galery/assets';
    public $css = [
        "css/bootstrap.css",
        "css/jquery-ui.min.css",
        "css/misk.css",
    ];
    public $js = [
        //"js/jquery.sortable.js",
        "js/html2canvas.min.js",
        "js/jquery-ui.min.js",
        "js/groups.min.js"
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];

}
