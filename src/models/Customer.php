<?php

namespace modava\customer\models;

use cheatsheet\Time;
use common\helpers\MyHelper;
use common\models\User;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerStatusCallTable;
use modava\customer\models\table\CustomerStatusDatHenTable;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerStatusDongYTable;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

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
    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_ONLINE = 'online';
    const SCENARIO_CLINIC = 'clinic';

    public $toastr_key = 'customer';
    public $country;
    public $province;
    public $district;
    public $agency;
    public $origin;
    public $remind_call;

    public function behaviors()
    {
        $status_call_dathen = ArrayHelper::map(CustomerStatusCall::getStatusCallDatHen(), 'id', 'id');
        $get_status_call_accept = CustomerStatusCallTable::getStatusCallDatHen();
        $get_status_dat_hen_accept = CustomerStatusDatHenTable::getDatHenDen();
        $status_call_accept = $get_status_call_accept[0]->id;
        $status_dat_hen_accept = $get_status_dat_hen_accept[0]->id;
        return array_merge(
            parent::behaviors(),
            [
                /* ALL */
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
                'birthday' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['birthday'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['birthday']
                    ],
                    'value' => function () {
                        if ($this->birthday != null) return date('Y-m-d', strtotime($this->birthday));
                        return null;
                    }
                ],
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
                'type' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['type']
                    ],
                    'value' => function () {
                        if ($this->scenario === self::SCENARIO_ONLINE) return CustomerTable::TYPE_ONLINE;
                        if ($this->scenario === self::SCENARIO_CLINIC) return CustomerTable::TYPE_DIRECT;
                        return CustomerTable::TYPE_ADMIN;
                    }
                ],
                /* SALES ONLINE */
                'time_lich_hen' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['time_lich_hen'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['time_lich_hen']
                    ],
                    'value' => function () {
                        if ($this->scenario === self::SCENARIO_CLINIC) return $this->time_lich_hen;
                        if ($this->time_lich_hen == null) return null;
                        if (is_numeric($this->time_lich_hen)) return $this->time_lich_hen;
                        return strtotime($this->time_lich_hen);
                    }
                ],
                'remind_call_time' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['remind_call_time'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['remind_call_time'],
                    ],
                    'value' => function () use ($status_call_dathen) {
                        if ($this->scenario === self::SCENARIO_CLINIC) return $this->remind_call_time;
                        if (in_array($this->status_call, $status_call_dathen)) return null;
                        if ($this->status_fail != null) return null;
                        if ($this->remind_call_time != null) {
                            if (is_numeric($this->remind_call_time)) return $this->remind_call_time;
                            return strtotime($this->remind_call_time);
                        }
                        return strtotime(date('d-m-Y') . ' +1day') + 8 * Time::SECONDS_IN_AN_HOUR; // Nếu không set nhắc lịch => nhắc lịch gọi vào 8h sáng ngày hôm sau
                    }
                ],
                /* CLINIC */
                'status_call' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['status_call']
                    ],
                    'value' => function () use ($status_call_accept) {
                        if ($this->scenario === self::SCENARIO_CLINIC) return $status_call_accept;
                        return $this->status_call;
                    }
                ],
                'status_dat_hen' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['status_dat_hen']
                    ],
                    'value' => function () use ($status_dat_hen_accept) {
                        if ($this->scenario === self::SCENARIO_CLINIC) return $status_dat_hen_accept;
                        return $this->status_dat_hen;
                    }
                ],
                'co_so' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['co_so'],
                    ],
                    'value' => function () {
                        if ($this->scenario === self::SCENARIO_CLINIC) {
                            if (!isset(\Yii::$app->user->identity->permission_coso) || \Yii::$app->user->identity->permission_coso == null) return null;
                            return \Yii::$app->user->identity->permission_coso;
                        }
                        return $this->co_so;
                    }
                ],
                'time_come' => [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_VALIDATE => ['time_come'],
                    ],
                    'value' => function () {
                        if ($this->scenario !== self::SCENARIO_ONLINE) {
                            if ($this->time_come == null) return null;
                            if (is_numeric($this->time_come)) return $this->time_come;
                            return strtotime($this->time_come);
                        }
                        return $this->time_come;
                    }
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $status_call_dathen = ArrayHelper::map(CustomerStatusCall::getStatusCallDatHen(), 'id', 'id');
        $status_dat_hen_den = ArrayHelper::map(CustomerStatusDatHenTable::getDatHenDen(), 'id', 'id');
        return [
            /* ALL */
            [['name', 'phone'], 'required'],
            ['phone', 'unique'],
            [['sex', 'ward'], 'integer'],
            [['birthday'], 'date', 'format' => 'php:d-m-Y'],
            [['name', 'phone', 'address'], 'string', 'max' => 255],
            /* SALES ONLINE */
            [['status_call'], 'required', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['sale_online_note'], 'string', 'max' => 255, 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['direct_sale_note'], 'string', 'max' => 255, 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_CLINIC]],
            [['fanpage_id', 'status_call', 'status_fail', 'co_so'], 'integer', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['co_so', 'time_lich_hen'], 'required', 'when' => function () use ($status_call_dathen) {
                return $this->status_call != null && in_array($this->status_call, $status_call_dathen);
            }, 'whenClient' => "function(){
                var status_call = $('#status_call').val() || null;
                return status_call != null && " . json_encode(array_values($status_call_dathen)) . ".includes(status_call);
            }", 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['remind_call_time'], 'required', 'when' => function () use ($status_call_dathen) {
                return $this->status_call != null && !in_array($this->status_call, $status_call_dathen) && $this->remind_call == true;
            }, 'whenClient' => "function(){
                var status_call = $('#status_call').val() || null;
                return status_call != null && !" . json_encode(array_values($status_call_dathen)) . ".includes(status_call) && $('#remind-call').is(':checked');
            }", 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['status_fail'], 'required', 'when' => function () use ($status_call_dathen) {
                return $this->status_call != null && !in_array($this->status_call, $status_call_dathen) && $this->remind_call == false;
            }, 'whenClient' => "function(){
                var status_call = $('#status_call').val() || null;
                return status_call != null && !" . json_encode(array_values($status_call_dathen)) . ".includes(status_call) && !$('#remind-call').is(':checked');
            }", 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['remind_call'], 'safe', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            [['status_call'], 'validateStatusCall', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_ONLINE]],
            /* CLINIC */
            [['status_dong_y', 'time_come'], 'required', 'when' => function () use ($status_dat_hen_den) {
                return in_array($this->status_dat_hen, $status_dat_hen_den);
            }, 'whenClient' => "function(){
                return " . json_encode(array_values($status_dat_hen_den)) . ".includes($('#status-dat-hen').val());
            }", 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_CLINIC]],
            [['status_dat_hen'], 'required', 'when' => function () {
                return $this->primaryKey != null;
            }, 'whenClient' => "function(){
                return '" . $this->primaryKey . "' == '';
            }", 'on' => self::SCENARIO_CLINIC],
            [['status_dat_hen'], 'validateStatusDatHen', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_CLINIC]],
            [['status_dong_y'], 'validateStatusDongY', 'on' => [self::SCENARIO_ADMIN, self::SCENARIO_CLINIC]]
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

    public function validateStatusCall()
    {
        if (!$this->hasErrors()) {
            $old_status_call = CustomerStatusCallTable::getById($this->getOldAttribute('status_call'));
            if ($old_status_call != null && $old_status_call->accept == CustomerStatusCallTable::STATUS_PUBLISHED && $this->statusCallHasOne->accept != CustomerStatusCallTable::STATUS_PUBLISHED) {
                $this->addError('status_call', 'Không thể chuyển trạng thái từ đặt hẹn sang fail');
            }
        }
    }

    public function validateStatusDatHen()
    {
        if (!$this->hasErrors()) {
            $old_status_dat_hen = CustomerStatusDatHenTable::getById($this->getOldAttribute('status_dat_hen'));
            if ($old_status_dat_hen != null && $old_status_dat_hen->accept == CustomerStatusDatHenTable::STATUS_PUBLISHED && $this->statusDatHenHasOne->accept != CustomerStatusDatHenTable::STATUS_PUBLISHED) {
                $this->addError('status_dat_hen', 'Không thể chuyển trạng thái khách đã đến thành khách không đến');
            }
        }
    }

    public function validateStatusDongY()
    {
        if (!$this->hasErrors()) {
            if ($this->statusDongYHasOne != null && $this->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED && count($this->orderHasMany) > 0) {
                $this->addError('status_dong_y', 'Khách đã tạo đơn hàng, không thể chuyển về trạng thái không đồng ý');
            }
        }
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
