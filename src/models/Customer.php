<?php

namespace modava\customer\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerTable;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $birthday
 * @property int $sex 0: nữ, 1: nam
 * @property string $phone
 * @property string $address
 * @property int $ward
 * @property string $avatar
 * @property int $fanpage_id
 * @property int $permission_user Quyền thuộc về nhân viên nào
 * @property int $type Khách online - Khách vãng lai
 * @property int $status_call KBM - Fail - Đặt hẹn
 * @property int $status_fail Tiềm năng - Ở xa - Có con nhỏ ...
 * @property int $status_dat_hen Đặt hẹn đến - Đặt hẹn không đến
 * @property int $status_dong_y Đồng ý - Không đồng ý - Làm dịch vụ khác
 * @property int $remind_call_time Khi nào nên gọi lại
 * @property int $time_lich_hen Thời gian lịch hẹn
 * @property int $time_come Thời gian khách đến
 * @property int $direct_sale Direct Sale phụ trách
 * @property int $co_so
 * @property string $sale_online_note Ghi chú của Sales Online
 * @property string $direct_sale_note Ghi chú của Direct Sale
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Customer extends CustomerTable
{
    public $toastr_key = 'customer';
    public $country;
    public $province;
    public $district;
    public $agency;
    public $origin;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'permission_user' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['permission_user']
                    ],
                    'value' => function () {
                        if ($this->permission_user != null) return $this->permission_user;
                        return Yii::$app->user->id;
                    }
                ],
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
                'time_lich_hen' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['time_lich_hen'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['time_lich_hen']
                    ],
                    'value' => function () {
                        if ($this->time_lich_hen == null) return null;
                        if (is_numeric($this->time_lich_hen)) return $this->time_lich_hen;
                        return strtotime($this->time_lich_hen);
                    }
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'permission_user', 'type'], 'required'],
            [['birthday'], 'safe'],
            [['sex', 'ward', 'fanpage_id', 'permission_user', 'type', 'status_call', 'status_fail', 'status_dat_hen', 'status_dong_y', 'time_lich_hen', 'time_come', 'direct_sale', 'co_so', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code', 'name', 'address', 'avatar', 'sale_online_note', 'direct_sale_note'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            [['country', 'province', 'district', 'agency', 'origin'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => CustomerModule::t('customer', 'ID'),
            'code' => CustomerModule::t('customer', 'Code'),
            'name' => CustomerModule::t('customer', 'Name'),
            'birthday' => CustomerModule::t('customer', 'Birthday'),
            'sex' => CustomerModule::t('customer', 'Sex'),
            'phone' => CustomerModule::t('customer', 'Phone'),
            'address' => CustomerModule::t('customer', 'Address'),
            'ward' => CustomerModule::t('customer', 'Ward'),
            'country' => CustomerModule::t('customer', 'Country'),
            'province' => CustomerModule::t('customer', 'Province'),
            'district' => CustomerModule::t('customer', 'District'),
            'avatar' => CustomerModule::t('customer', 'Avatar'),
            'fanpage_id' => CustomerModule::t('customer', 'Fanpage ID'),
            'permission_user' => CustomerModule::t('customer', 'Permission User'),
            'type' => CustomerModule::t('customer', 'Type'),
            'status_call' => CustomerModule::t('customer', 'Status Call'),
            'status_fail' => CustomerModule::t('customer', 'Status Fail'),
            'status_dat_hen' => CustomerModule::t('customer', 'Status Dat Hen'),
            'status_dong_y' => CustomerModule::t('customer', 'Status Dong Y'),
            'time_lich_hen' => CustomerModule::t('customer', 'Time Lich Hen'),
            'time_come' => CustomerModule::t('customer', 'Time Come'),
            'direct_sale' => CustomerModule::t('customer', 'Direct Sale'),
            'co_so' => CustomerModule::t('customer', 'Co So'),
            'sale_online_note' => CustomerModule::t('customer', 'Sale Online Note'),
            'direct_sale_note' => CustomerModule::t('customer', 'Direct Sale Note'),
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
