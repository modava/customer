<?php

namespace modava\customer\assets;

use yii\web\AssetBundle;

class CustomerAdminAsset extends AssetBundle
{
    public $sourcePath = '@customerweb';
    public $css = [
    ];
    public $js = [
        'js/customer-admin.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        CustomerCustomAsset::class
    ];
}