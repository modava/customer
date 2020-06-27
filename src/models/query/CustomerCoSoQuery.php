<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerCoSo;

/**
 * This is the ActiveQuery class for [[CustomerCoSo]].
 *
 * @see CustomerCoSo
 */
class CustomerCoSoQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerCoSo::tableName() . '.status' => CustomerCoSo::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerCoSo::tableName() . '.status' => CustomerCoSo::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerCoSo::tableName() . '.id' => SORT_DESC]);
    }
}
