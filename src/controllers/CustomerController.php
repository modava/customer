<?php

namespace modava\customer\controllers;

use modava\customer\components\MyCustomerController;


class CustomerController extends MyCustomerController
{

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}
