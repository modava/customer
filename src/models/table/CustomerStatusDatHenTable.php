<?php

namespace modava\customer\models\table;

use cheatsheet\Time;
use modava\customer\models\query\CustomerStatusDatHenQuery;
use Yii;
use yii\db\ActiveRecord;

class CustomerStatusDatHenTable extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'customer_status_dat_hen';
    }

    public static function find()
    {
        return new CustomerStatusDatHenQuery(get_called_class());
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-customer-status-dat-hen-get-by-id-' . $this->id . '-' . $this->language,
            'redis-customer-status-dat-hen-get-all-dat-hen-' . $this->language,
            'redis-customer-status-dat-hen-get-dat-hen-den-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-customer-status-dat-hen-get-by-id-' . $this->id . '-' . $this->language,
            'redis-customer-status-dat-hen-get-all-dat-hen-' . $this->language,
            'redis-customer-status-dat-hen-get-dat-hen-den-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public static function getById($id, $language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-customer-status-dat-hen-get-by-id-' . $id . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['id' => $id, 'language' => $language])->published()->one();
            $cache->set($key, $data);
        }
        return $data;
    }

    public static function getAllDatHen($language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-customer-status-dat-hen-get-all-dat-hen-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['language' => $language])->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }

    public static function getDatHenDen($language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-customer-status-dat-hen-get-dat-hen-den-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['language' => $language])->accepted()->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }
}