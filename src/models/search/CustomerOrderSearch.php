<?php

namespace modava\customer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\customer\models\CustomerOrder;

/**
 * CustomerOrderSearch represents the model behind the search form of `modava\customer\models\CustomerOrder`.
 */
class CustomerOrderSearch extends CustomerOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'co_so'], 'integer'],
            [['code', 'status'], 'safe'],
            [['total', 'discount'], 'number'],
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
        $query = CustomerOrder::find();

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
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            'discount' => $this->discount,
            'co_so' => $this->co_so,
            'ordered_at' => $this->ordered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
