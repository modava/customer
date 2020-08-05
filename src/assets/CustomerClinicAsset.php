<?php


namespace modava\customer\assets;


use yii\web\AssetBundle;

class CustomerClinicAsset extends AssetBundle
{
    public $sourcePath = '@customerweb';
    public $css = [
    ];
    public $js = [
        'js/customer-clinic.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        CustomerCustomAsset::class
    ];
}