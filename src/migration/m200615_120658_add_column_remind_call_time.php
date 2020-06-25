<?php

use yii\db\Migration;

/**
 * Class m200615_120658_add_column_remind_call_time
 */
class m200615_120658_add_column_remind_call_time extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $get_field_customer = Yii::$app->db->getTableSchema('customer')->columns;
        if (!array_key_exists('remind_call_time', $get_field_customer)) {
            $this->addColumn('customer', 'remind_call_time', $this->integer()->null()->after('status_dong_y')->comment('Khi nào nên gọi lại.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200615_120658_add_column_remind_call_time cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200615_120658_add_column_remind_call_time cannot be reverted.\n";

        return false;
    }
    */
}
