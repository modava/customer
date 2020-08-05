<?php

namespace modava\customer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\customer\models\CustomerPayment;

/**
 * CustomerPaymentSearch represents the model behind the search form of `modava\customer\models\CustomerPayment`.
 */
class CustomerPaymentSearch extends CustomerPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'payments', 'type', 'co_so', 'payment_at'], 'integer'],
            [['price'], 'number'],
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
        $query = CustomerPayment::find();

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
            'order_id' => $this->order_id,
            'payments' => $this->payments,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
