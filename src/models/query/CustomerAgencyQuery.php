<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerAgency;

/**
 * This is the ActiveQuery class for [[CustomerAgency]].
 *
 * @see CustomerAgency
 */
class CustomerAgencyQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerAgency::tableName() . '.status' => CustomerAgency::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerAgency::tableName() . '.status' => CustomerAgency::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerAgency::tableName() . '.id' => SORT_DESC]);
    }
}
