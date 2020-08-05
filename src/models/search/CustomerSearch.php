<?php

namespace modava\customer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\customer\models\Customer;
use modava\customer\models\table\CustomerStatusCallTable;

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
            [['name'], 'string', 'on' => [self::SCENARIO_ONLINE, self::SCENARIO_CLINIC, self::SCENARIO_ADMIN]],
            [['birthday'], 'date', 'format' => 'php:d-m-Y', 'on' => [self::SCENARIO_ONLINE, self::SCENARIO_CLINIC, self::SCENARIO_ADMIN]],
            [['sex', 'created_at', 'created_by'], 'integer', 'on' => [self::SCENARIO_ONLINE, self::SCENARIO_CLINIC, self::SCENARIO_ADMIN]],
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

        if ($this->scenario === self::SCENARIO_ONLINE) {
            $query->andWhere([self::tableName() . '.type' => self::TYPE_ONLINE]);
        }
        if ($this->scenario === self::SCENARIO_CLINIC) {
            $query->joinWith(['statusCallHasOne'])->where([CustomerStatusCallTable::tableName() . '.accept' => CustomerStatusCallTable::STATUS_PUBLISHED]);
        }

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
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
