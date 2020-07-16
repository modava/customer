<?php

namespace modava\customer\models\search;

use modava\customer\models\table\CustomerStatusCallTable;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\customer\models\Customer;

/**
 * SalesOnlineRemindCallSearch represents the model behind the search form of `modava\customer\models\Customer`.
 */
class RemindCallSearch extends Customer
{
    public $remind_call_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ward', 'fanpage_id', 'permission_user', 'type', 'status_call', 'status_fail', 'status_dat_hen', 'status_dong_y', 'time_lich_hen', 'time_come', 'direct_sale', 'co_so', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code', 'name', 'birthday', 'sex', 'phone', 'address', 'avatar', 'sale_online_note', 'direct_sale_note', 'remind_call_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Customer::find()
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.name',
                self::tableName() . '.phone',
                self::tableName() . '.remind_call_time',
                self::tableName() . '.created_by',
                self::tableName() . '.created_at',
                "FROM_UNIXTIME(remind_call_time, '%d-%m-%Y') AS remind_call_date"
            ])
            ->joinWith(['statusCallHasOne'])
            ->where(['<>', CustomerStatusCallTable::tableName() . '.accept', CustomerStatusCallTable::STATUS_PUBLISHED])
            ->andWhere(self::tableName() . '.status_fail IS NULL');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->permission_user != null) {
            $query->andFilterWhere([self::tableName() . '.permission_user' => $this->permission_user]);
        }

        // grid filtering conditions
        $query->orderBy([
            new \yii\db\Expression('FIELD (remind_call_date, ' . strtotime(date('d-m-Y')) . ') DESC, remind_call_time ASC'),
            'remind_call_time' => SORT_DESC
        ]);
//        echo $query->createCommand()->rawSql;die;

        return $dataProvider;
    }

    public static function getSalesOnlineRemindCall($user_id = null)
    {
        $today = strtotime(date('d-m-Y'));
        $query = self::find()
            ->joinWith(['statusCallHasOne'])
            ->where(['<>', CustomerStatusCallTable::tableName() . '.accept', CustomerStatusCallTable::STATUS_PUBLISHED])
            ->andWhere([self::tableName() . '.status_fail' => null])
            ->andWhere(['BETWEEN', self::tableName() . '.remind_call_time', $today, $today + 86399]);
        if ($user_id != null) {
            $query->andWhere([self::tableName() . '.permission_user' => $user_id]);
        }
        return $query->count();
    }
}
