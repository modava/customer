<?php

use yii\db\Migration;

/**
 * Class m200609_114519_create_table_customer
 */
class m200609_114519_create_table_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table_customer = Yii::$app->db->getTableSchema('customer');
        if ($check_table_customer === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer', [
                'id' => $this->primaryKey(),
                'code' => $this->string(255)->null(),
                'name' => $this->string(255)->notNull(),
                'birthday' => $this->date()->null(),
                'sex' => $this->tinyInteger(1)->defaultValue(0)->comment('0: nữ, 1: nam'),
                'phone' => $this->string(30)->notNull(),
                'address' => $this->string(255)->null(),
                'ward' => $this->integer(11)->null(),
                'avatar' => $this->string(255)->null(),
                'fanpage_id' => $this->integer(11)->null(),
                'permission_user' => $this->integer(11)->notNull()->comment('Quyền thuộc về nhân viên nào'),
                'type' => $this->integer(11)->notNull()->comment('0: Chưa xác định - 1: Khách online - 2: Khách vãng lai'),
                'status_call' => $this->integer(11)->null()->comment('KBM - Fail - Đặt hẹn'),
                'status_fail' => $this->integer(11)->null()->comment('Tiềm năng - Ở xa - Có con nhỏ ...'),
                'status_dat_hen' => $this->integer(11)->null()->comment('Đặt hẹn đến - Đặt hẹn không đến'),
                'status_dong_y' => $this->integer(11)->null()->comment('Đồng ý - Không đồng ý - Làm dịch vụ khác'),
                'remind_call_time' => $this->integer()->null()->comment('Khi nào nên gọi lại.'),
                'time_lich_hen' => $this->integer(11)->null()->comment('Thời gian lịch hẹn'),
                'time_come' => $this->integer(11)->null()->comment('Thời gian khách đến'),
                'direct_sale' => $this->integer(11)->null()->comment('Direct Sale phụ trách'),
                'co_so' => $this->integer(11)->null(),
                'sale_online_note' => $this->string(255)->null()->comment('Ghi chú của Sales Online'),
                'direct_sale_note' => $this->string(255)->null()->comment('Ghi chú của Direct Sale'),
                'created_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'updated_by' => $this->integer(11)->null(),
            ], $tableOptions);
            $this->addForeignKey('fk_customer_ward_location_ward', 'customer', 'ward', 'location_ward', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_fanpage_id_customer_fanpage', 'customer', 'fanpage_id', 'customer_fanpage', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_permission_user_user', 'customer', 'permission_user', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_call_customer_status_call', 'customer', 'status_call', 'customer_status_call', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_fail_customer_status_fail', 'customer', 'status_fail', 'customer_status_fail', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_dat_hen_customer_status_dat_hen', 'customer', 'status_dat_hen', 'customer_status_dat_hen', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_dong_y_customer_status_dong_y', 'customer', 'status_dong_y', 'customer_status_dong_y', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_direct_sale_user', 'customer', 'direct_sale', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_co_so_customer_co_so', 'customer', 'co_so', 'customer_co_so', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_created_by_user', 'customer', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_updated_by_user', 'customer', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200609_114519_create_table_customer cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200609_114519_create_table_customer cannot be reverted.\n";

        return false;
    }
    */
}
