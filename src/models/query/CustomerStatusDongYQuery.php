<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerStatusDongY;

/**
 * This is the ActiveQuery class for [[CustomerStatusDongY]].
 *
 * @see CustomerStatusDongY
 */
class CustomerStatusDongYQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerStatusDongY::tableName() . '.status' => CustomerStatusDongY::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerStatusDongY::tableName() . '.status' => CustomerStatusDongY::STATUS_DISABLED]);
    }

    public function accepted()
    {
        return $this->andWhere([CustomerStatusDongY::tableName() . '.accept' => CustomerStatusDongY::STATUS_PUBLISHED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerStatusDongY::tableName() . '.id' => SORT_DESC]);
    }
}
