<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerStatusCall;

/**
 * This is the ActiveQuery class for [[CustomerStatusCall]].
 *
 * @see CustomerStatusCall
 */
class CustomerStatusCallQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerStatusCall::tableName() . '.status' => CustomerStatusCall::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerStatusCall::tableName() . '.status' => CustomerStatusCall::STATUS_DISABLED]);
    }

    public function accepted()
    {
        return $this->andWhere([CustomerStatusCall::tableName() . '.accept' => CustomerStatusCall::STATUS_PUBLISHED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerStatusCall::tableName() . '.id' => SORT_DESC]);
    }
}
