<?php

namespace modava\customer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\customer\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `modava\customer\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ward', 'fanpage_id', 'permission_user', 'type', 'status_call', 'status_fail', 'status_dat_hen', 'status_dong_y', 'time_lich_hen', 'time_come', 'direct_sale', 'co_so', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code', 'name', 'birthday', 'sex', 'phone', 'address', 'avatar', 'sale_online_note', 'direct_sale_note'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'ward' => $this->ward,
            'fanpage_id' => $this->fanpage_id,
            'permission_user' => $this->permission_user,
            'type' => $this->type,
            'status_call' => $this->status_call,
            'status_fail' => $this->status_fail,
            'status_dat_hen' => $this->status_dat_hen,
            'status_dong_y' => $this->status_dong_y,
            'time_lich_hen' => $this->time_lich_hen,
            'time_come' => $this->time_come,
            'direct_sale' => $this->direct_sale,
            'co_so' => $this->co_so,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'sale_online_note', $this->sale_online_note])
            ->andFilterWhere(['like', 'direct_sale_note', $this->direct_sale_note]);

        return $dataProvider;
    }
}
