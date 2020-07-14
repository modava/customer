<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerStatusFail;

/**
 * This is the ActiveQuery class for [[CustomerStatusFail]].
 *
 * @see CustomerStatusFail
 */
class CustomerStatusFailQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerStatusFail::tableName() . '.status' => CustomerStatusFail::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerStatusFail::tableName() . '.status' => CustomerStatusFail::STATUS_DISABLED]);
    }

    public function typeCall()
    {
        return $this->andWhere([CustomerStatusFail::tableName() . '.type' => CustomerStatusFail::TYPE_CALL_FAIL]);
    }

    public function typeDongY()
    {
        return $this->andWhere([CustomerStatusFail::tableName() . '.type' => CustomerStatusFail::TYPE_DONG_Y_FAIL]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerStatusFail::tableName() . '.id' => SORT_DESC]);
    }
}
