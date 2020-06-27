<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerStatusDatHen;

/**
 * This is the ActiveQuery class for [[CustomerStatusDatHen]].
 *
 * @see CustomerStatusDatHen
 */
class CustomerStatusDatHenQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerStatusDatHen::tableName() . '.status' => CustomerStatusDatHen::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerStatusDatHen::tableName() . '.status' => CustomerStatusDatHen::STATUS_DISABLED]);
    }

    public function accepted()
    {
        return $this->andWhere([CustomerStatusDatHen::tableName() . '.accept' => CustomerStatusDatHen::STATUS_PUBLISHED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerStatusDatHen::tableName() . '.id' => SORT_DESC]);
    }
}
