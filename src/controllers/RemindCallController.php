<?php

namespace modava\customer\controllers;

use yii\db\Exception;
use Yii;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use modava\customer\CustomerModule;
use backend\components\MyController;
use modava\customer\models\Customer;
use modava\customer\models\search\RemindCallSearch;

/**
 * SalesOnlineRemindCallController implements the CRUD actions for Customer model.
 */
class RemindCallController extends MyController
{
    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RemindCallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
