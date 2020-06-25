<?php

namespace modava\customer\controllers;

use modava\customer\models\table\CustomerStatusDongYTable;
use yii\db\Exception;
use Yii;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use modava\customer\CustomerModule;
use backend\components\MyController;
use modava\customer\models\CustomerTreatmentSchedule;
use modava\customer\models\search\CustomerTreatmentScheduleSeach;

/**
 * CustomerTreatmentScheduleController implements the CRUD actions for CustomerTreatmentSchedule model.
 */
class CustomerTreatmentScheduleController extends MyController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CustomerTreatmentSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $order_id = Yii::$app->request->get('order_id');
        $searchModel = new CustomerTreatmentScheduleSeach([
            'order_id' => $order_id
        ]);
        if ($order_id != null && ($searchModel->orderHasOne == null ||
                $searchModel->orderHasOne->customerHasOne == null ||
                $searchModel->orderHasOne->customerHasOne->statusDongYHasOne == null ||
                $searchModel->orderHasOne->customerHasOne->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED
            )) {
            Yii::$app->session->setFlash('toastr-' . $searchModel->toastr_key . '-index', [
                'title' => 'Thông báo',
                'text' => CustomerModule::t('customer', 'Không tìm thấy lịch điều trị theo đơn hàng "' . $order_id . '" hoặc khách hàng chưa đồng ý làm dịch vụ'),
                'type' => 'warning'
            ]);
            return $this->redirect(['index']);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single CustomerTreatmentSchedule model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CustomerTreatmentSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $order_id = Yii::$app->request->get('order_id');
        $model = new CustomerTreatmentSchedule([
            'order_id' => $order_id
        ]);
        if ($order_id != null && ($model->orderHasOne == null ||
                $model->orderHasOne->customerHasOne == null ||
                $model->orderHasOne->customerHasOne->statusDongYHasOne == null ||
                $model->orderHasOne->customerHasOne->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED
            )) {
            Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-form', [
                'title' => 'Thông báo',
                'text' => CustomerModule::t('customer', 'Không tìm thấy đơn hàng "' . $order_id . '" hoặc khách hàng chưa đồng ý làm dịch vụ'),
                'type' => 'warning'
            ]);
            return $this->redirect(['create']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-view', [
                    'title' => 'Thông báo',
                    'text' => 'Tạo mới thành công',
                    'type' => 'success'
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = Html::tag('p', 'Tạo mới thất bại');
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-form', [
                    'title' => 'Thông báo',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerTreatmentSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-view', [
                        'title' => 'Thông báo',
                        'text' => 'Cập nhật thành công',
                        'type' => 'success'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors = Html::tag('p', 'Cập nhật thất bại');
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-form', [
                    'title' => 'Thông báo',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerTreatmentSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => 'Xoá thành công',
                    'type' => 'success'
                ]);
            } else {
                $errors = Html::tag('p', 'Xoá thất bại');
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                'title' => 'Thông báo',
                'text' => Html::tag('p', 'Xoá thất bại: ' . $ex->getMessage()),
                'type' => 'warning'
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerTreatmentSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerTreatmentSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    protected function findModel($id)
    {
        if (($model = CustomerTreatmentSchedule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('customer', 'The requested page does not exist.'));
    }
}
