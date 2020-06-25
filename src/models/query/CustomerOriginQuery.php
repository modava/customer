<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerOrigin;

/**
 * This is the ActiveQuery class for [[CustomerOrigin]].
 *
 * @see CustomerOrigin
 */
class CustomerOriginQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerOrigin::tableName() . '.status' => CustomerOrigin::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerOrigin::tableName() . '.status' => CustomerOrigin::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerOrigin::tableName() . '.id' => SORT_DESC]);
    }
}
