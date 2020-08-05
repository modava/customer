<?php

namespace modava\customer\models\query;

use modava\customer\models\CustomerProductCategory;

/**
 * This is the ActiveQuery class for [[CustomerProductCategory]].
 *
 * @see CustomerProductCategory
 */
class CustomerProductCategoryQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([CustomerProductCategory::tableName() . '.status' => CustomerProductCategory::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([CustomerProductCategory::tableName() . '.status' => CustomerProductCategory::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy([CustomerProductCategory::tableName() . '.id' => SORT_DESC]);
    }
}
