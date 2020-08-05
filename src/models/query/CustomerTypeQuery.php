<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerType;

/**
 * This is the ActiveQuery class for [[CustomerType]].
 *
 * @see CustomerType
 */
class CustomerTypeQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerType::tableName() . '.status' => CustomerType::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerType::tableName() . '.status' => CustomerType::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerType::tableName() . '.id' => SORT_DESC]);
    }
}
