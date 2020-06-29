<?php

namespace modava\customer\models\search;

use modava\customer\models\Clinic;
use modava\customer\models\table\CustomerStatusCallTable;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ClinicSearch extends Clinic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        $status_call_dat_hen = ArrayHelper::map(CustomerStatusCallTable::getStatusCallDatHen(), 'id', 'id');
        $query = Clinic::find()->joinWith(['statusCallHasOne'])->where([CustomerStatusCallTable::tableName() . '.accept' => CustomerStatusCallTable::STATUS_PUBLISHED]);

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

        return $dataProvider;
    }
}