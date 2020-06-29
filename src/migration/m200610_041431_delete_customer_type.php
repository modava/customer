<?php

use yii\db\Migration;

/**
 * Class m200610_041431_delete_customer_type
 */
class m200610_041431_delete_customer_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_customer_type = Yii::$app->db->getTableSchema('customer_type');
        if ($check_customer_type !== null) {
            $this->dropTable('customer_type');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200610_041431_delete_customer_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200610_041431_delete_customer_type cannot be reverted.\n";

        return false;
    }
    */
}
