<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerOrder;

/**
 * This is the ActiveQuery class for [[CustomerOrder]].
 *
 * @see CustomerOrder
 */
class CustomerOrderQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerOrder::tableName() . '.status' => CustomerOrder::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerOrder::tableName() . '.status' => CustomerOrder::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerOrder::tableName() . '.id' => SORT_DESC]);
    }
}
