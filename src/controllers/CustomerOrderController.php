<?php

namespace modava\customer\controllers;

use modava\customer\models\table\CustomerOrderTable;
use modava\customer\models\table\CustomerStatusDongYTable;
use modava\customer\models\table\CustomerTable;
use yii\db\Exception;
use Yii;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use modava\customer\CustomerModule;
use backend\components\MyController;
use modava\customer\models\CustomerOrder;
use modava\customer\models\search\CustomerOrderSearch;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CustomerOrderController implements the CRUD actions for CustomerOrder model.
 */
class CustomerOrderController extends MyController
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
     * Lists all CustomerOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single CustomerOrder model.
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
     * Creates a new CustomerOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $customer_id = Yii::$app->request->get('customer_id');
        $model = new CustomerOrder([
            'customer_id' => $customer_id
        ]);
        if ($customer_id != null && ($model->customerHasOne == null || $model->customerHasOne->statusDongYHasOne == null || $model->customerHasOne->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED)) {
            Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                'title' => 'Thông báo',
                'text' => 'Khách hàng không tồn tại hoặc chưa đồng ý làm dịch vụ',
                'type' => 'warning'
            ]);
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save() && $model->saveOrderDetail()) {
                $transaction->commit();
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-view', [
                    'title' => 'Thông báo',
                    'text' => 'Tạo mới thành công',
                    'type' => 'success'
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
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
     * Updates an existing CustomerOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
            if ($model->validate() && $model->save() && $order_data = $model->saveOrderDetail()) {
                $transaction->commit();
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-view', [
                    'title' => 'Thông báo',
                    'text' => 'Cập nhật thành công',
                    'type' => 'success'
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
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
        } else {
            $model->order_detail = [];
            if (is_array($model->orderDetailHasMany)) {
                foreach ($model->orderDetailHasMany as $order_detail) {
                    $model->order_detail[] = $order_detail->getAttributes();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionValidateOrder($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $model = new CustomerOrder([
                'customer_id' => Yii::$app->request->get('customer_id')
            ]);
            if ($id != null) $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                return ActiveForm::validate($model);
            }
        }
        return [
            'code' => 403,
            'msg' => CustomerModule::t('customer', 'Không có quyền truy cập')
        ];
    }

    /**
     * Deletes an existing CustomerOrder model.
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

    public function actionGetOrderByCustomer()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $customer_id = Yii::$app->request->get('customer_id');
            $data = CustomerOrderTable::getOrderUnFinishByCustomer($customer_id);
            return [
                'code' => 200,
                'data' => ArrayHelper::map($data, 'id', 'code')
            ];
        }
        return [
            'code' => 403,
            'data' => CustomerModule::t('customer', 'Không có quyền truy cập')
        ];
    }

    /**
     * Finds the CustomerOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    protected function findModel($id)
    {
        if (($model = CustomerOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('customer', 'The requested page does not exist.'));
    }
}
