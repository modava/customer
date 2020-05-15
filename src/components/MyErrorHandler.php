<?php

namespace modava\customer\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@modava/customer/views/error/error.php';

}