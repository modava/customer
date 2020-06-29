<?php

namespace modava\customer\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerOrderDetailTable;
use modava\customer\models\table\CustomerOrderTable;
use modava\product\models\Product;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "customer_order_detail".
 *
 * @property int $order_id
 * @property int $product_id
 * @property int $qty Số lượng
 * @property double $price Đơn giá
 * @property double $discount Chiết khấu
 * @property int $discount_by Chiết khấu theo
 * @property string $reason_discount Lý do chiết khấu
 */
class CustomerOrderDetail extends CustomerOrderDetailTable
{
    const SCENARIO_SAVE = 'save';
    public $toastr_key = 'customer-order-detail';

    public function __construct($order_id = null)
    {
        $this->order_id = $order_id;
        parent::__construct([]);
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id'], 'required', 'on' => self::SCENARIO_SAVE],
            [['order_id'], 'exist', 'targetClass' => CustomerOrderTable::class, 'targetAttribute' => ['order_id' => 'id'], 'on' => self::SCENARIO_SAVE],
            [['order_id'], 'integer', 'on' => self::SCENARIO_SAVE],
            [['product_id'], 'required'],
            [['product_id'], 'exist', 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['product_id'], 'integer'],
            [['qty'], 'integer', 'min' => 1],
            [['price', 'discount', 'discount_by'], 'number'],
            [['reason_discount'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => CustomerModule::t('customer', 'Order ID'),
            'product_id' => CustomerModule::t('customer', 'Product ID'),
            'qty' => CustomerModule::t('customer', 'Qty'),
            'price' => CustomerModule::t('customer', 'Price'),
            'discount' => CustomerModule::t('customer', 'Discount'),
            'reason_discount' => CustomerModule::t('customer', 'Reason Discount'),
        ];
    }


}
