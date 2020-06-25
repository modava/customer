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
