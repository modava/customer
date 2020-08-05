<?php

use yii\db\Migration;

/**
 * Class m200710_070636_add_column_type_table_customer_status_fail
 */
class m200710_070636_add_column_type_table_customer_status_fail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_column = Yii::$app->db->getTableSchema('customer_status_fail')->columns;
        if (!array_key_exists('type', $check_column)) {
            $this->addColumn('customer_status_fail', 'type', $this->integer(11)->null()->defaultValue(0)->after('description')->comment('Loại, 0: status call fail, 1: status dong y fail'));
        }
        $check_column = Yii::$app->db->getTableSchema('customer')->columns;
        if (!array_key_exists('status_dong_y_fail', $check_column)) {
            $this->addColumn('customer', 'status_dong_y_fail', $this->integer(11)->null()->after('status_dong_y')->comment('Lý do khách từ chối làm dịch vụ'));
            $this->addForeignKey('foreignkey-customer-status_dong_y_fail-customer_status_fail-id', 'customer', 'status_dong_y_fail', 'customer_status_fail', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200710_070636_add_column_type_table_customer_status_fail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200710_070636_add_column_type_table_customer_status_fail cannot be reverted.\n";

        return false;
    }
    */
}
