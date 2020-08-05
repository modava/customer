<?php

namespace modava\customer\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CustomerCustomAsset extends AssetBundle
{
    public $sourcePath = '@customerweb';
    public $css = [
        'css/customCustomer.css',
    ];
    public $js = [
        'js/customCustomer.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
