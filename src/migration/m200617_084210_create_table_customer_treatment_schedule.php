<?php

use yii\db\Migration;

/**
 * Class m200617_084210_create_table_customer_treatment_schedule
 */
class m200617_084210_create_table_customer_treatment_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_customer_treatment_schedule = Yii::$app->db->getTableSchema('customer_treatment_schedule');
        if ($check_customer_treatment_schedule === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_treatment_schedule', [
                'id' => $this->primaryKey(),
                'order_id' => $this->integer(11)->notNull(),
                'co_so' => $this->integer(11)->null()->comment('Lịch điều trị lập ở cơ sở nào'),
                'time_start' => $this->integer(11)->null()->comment('Thời gian bắt đầu'),
                'time_end' => $this->integer(11)->null()->comment('Thời gian kết thúc'),
                'note' => $this->string(500)->null()->comment('Ghi chú điều trị'),
                'status' => $this->tinyInteger(1)->null()->defaultValue(0)->comment('Trạng thái lịch điều trị - 0: Chờ xử lý, 1: Đã kết thúc, 2: Đang tiến hành'),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addForeignKey('fk_customer_treatment_schedule_order_id_customer_order', 'customer_treatment_schedule', 'order_id', 'customer_order', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_treatment_schedule_co_so_customer_co_so', 'customer_treatment_schedule', 'co_so', 'customer_co_so', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_treatment_schedule_created_by_user', 'customer_treatment_schedule', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_treatment_schedule_updated_by_user', 'customer_treatment_schedule', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_084210_create_table_customer_treatment_schedule cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_084210_create_table_customer_treatment_schedule cannot be reverted.\n";

        return false;
    }
    */
}
