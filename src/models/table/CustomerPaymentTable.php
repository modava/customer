<?php

namespace modava\customer\models\table;

use cheatsheet\Time;
use Yii;
use yii\db\ActiveRecord;

class CustomerPaymentTable extends \yii\db\ActiveRecord
{
    const DISCOUNT_BY_MONEY = '1';
    const DISCOUNT_BY_PERCENT = '2';
    const DISCOUNT = [
        self::DISCOUNT_BY_MONEY => 'đ',
        self::DISCOUNT_BY_PERCENT => '%',
    ];
    const TYPE_TIEN_MAT = 0;
    const TYPE_CHUYEN_KHOAN = 1;
    const TYPE = [
        self::TYPE_TIEN_MAT => 'Tiền mặt',
        self::TYPE_CHUYEN_KHOAN => 'Chuyển khoản'
    ];
    const PAYMENTS_THANH_TOAN = 0;
    const PAYMENTS_DAT_COC = 1;
    const PAYMENTS = [
        self::PAYMENTS_THANH_TOAN => 'Thanh toán',
        self::PAYMENTS_DAT_COC => 'Đặt cọc'
    ];

    public static function tableName()
    {
        return 'customer_payment';
    }

    public function getOrderHasOne()
    {
        return $this->hasOne(CustomerOrderTable::class, ['id' => 'order_id']);
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-customer-order-table-get-by-id-' . $this->order_id
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
