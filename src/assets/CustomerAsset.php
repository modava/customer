<?php

namespace modava\customer\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CustomerAsset extends AssetBundle
{
    public $sourcePath = '@backendWeb';
    public $css = [
        'vendors/datatables.net-dt/css/jquery.dataTables.min.css',
        'vendors/bootstrap/dist/css/bootstrap.min.css',
        "vendors/jquery-toggles/css/toggles.css",
        "vendors/jquery-toggles/css/themes/toggles-light.css",
    ];
    public $js = [
        "vendors/popper.js/dist/umd/popper.min.js",
        "vendors/bootstrap/dist/js/bootstrap.min.js",
        "dist/js/jquery.slimscroll.js",
        "dist/js/dropdown-bootstrap-extended.js",
        "vendors/jquery-toggles/toggles.min.js",
        "dist/js/toggle-data.js",
        "vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js",
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
