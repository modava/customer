<?php

namespace modava\customer\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerProductCategoryTable;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
* This is the model class for table "customer_product_category".
*
    * @property int $id
    * @property string $name
    * @property string $description Mô tả danh mục
    * @property int $status 0: disabled, 1: published
    * @property string $language Language
    * @property int $created_at
    * @property int $created_by
    * @property int $updated_at
    * @property int $updated_by
    *
            * @property CustomerProduct[] $customerProducts
            * @property User $createdBy
            * @property User $updatedBy
    */
class CustomerProductCategory extends CustomerProductCategoryTable
{
    public $toastr_key = 'customer-product-category';
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'preserveNonEmptyValues' => true,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]
        );
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
			[['name'], 'required'],
			[['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
			[['language'], 'string'],
			[['name', 'description'], 'string', 'max' => 255],
			[['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
			[['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
		];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => CustomerModule::t('customer', 'ID'),
            'name' => CustomerModule::t('customer', 'Name'),
            'description' => CustomerModule::t('customer', 'Description'),
            'status' => CustomerModule::t('customer', 'Status'),
            'language' => CustomerModule::t('customer', 'Language'),
            'created_at' => CustomerModule::t('customer', 'Created At'),
            'created_by' => CustomerModule::t('customer', 'Created By'),
            'updated_at' => CustomerModule::t('customer', 'Updated At'),
            'updated_by' => CustomerModule::t('customer', 'Updated By'),
        ];
    }

    /**
    * Gets query for [[User]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
    * Gets query for [[User]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
