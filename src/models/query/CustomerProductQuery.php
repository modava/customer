<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerProduct;

/**
 * This is the ActiveQuery class for [[CustomerProduct]].
 *
 * @see CustomerProduct
 */
class CustomerProductQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerProduct::tableName() . '.status' => CustomerProduct::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerProduct::tableName() . '.status' => CustomerProduct::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerProduct::tableName() . '.id' => SORT_DESC]);
    }
}
