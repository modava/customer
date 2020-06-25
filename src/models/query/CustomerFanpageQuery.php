<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerFanpage;

/**
 * This is the ActiveQuery class for [[CustomerFanpage]].
 *
 * @see CustomerFanpage
 */
class CustomerFanpageQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerFanpage::tableName() . '.status' => CustomerFanpage::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerFanpage::tableName() . '.status' => CustomerFanpage::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerFanpage::tableName() . '.id' => SORT_DESC]);
    }
}
