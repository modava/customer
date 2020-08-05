<?php

namespace modava\customer\models\table;

use cheatsheet\Time;
use modava\customer\models\query\CustomerStatusDongYQuery;
use Yii;
use yii\db\ActiveRecord;

class CustomerStatusDongYTable extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'customer_status_dong_y';
    }

    public static function find()
    {
        return new CustomerStatusDongYQuery(get_called_class());
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-customer-status-dong-y-get-by-id-' . $this->id . '-' . $this->language,
            'redis-customer-status-dong-y-get-all-' . $this->language,
            'redis-customer-status-dong-y-get-all-dong-y-' . $this->language
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
            'redis-customer-status-dong-y-get-by-id-' . $this->id . '-' . $this->language,
            'redis-customer-status-dong-y-get-all-' . $this->language,
            'redis-customer-status-dong-y-get-all-dong-y-' . $this->language
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
        $key = 'redis-customer-status-dong-y-get-by-id-' . $id . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['id' => $id, 'language' => $language])->published()->one();
            $cache->set($key, $data);
        }
        return $data;
    }

    public static function getAll($language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-customer-status-dong-y-get-all-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['language' => $language])->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }

    public static function getAllDongY($language = null)
    {
        $language = $language ?: Yii::$app->language;
        $cache = Yii::$app->cache;
        $key = 'redis-customer-status-dong-y-get-all-dong-y-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['language' => $language])->accepted()->published()->all();
            $cache->set($key, $data);
        }
        return $data;
    }
}