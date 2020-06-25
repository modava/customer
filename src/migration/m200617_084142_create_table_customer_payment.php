<?php

use yii\db\Migration;

/**
 * Class m200617_084142_create_table_customer_payment
 */
class m200617_084142_create_table_customer_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_customer_payment = Yii::$app->db->getTableSchema('customer_payment');
        if ($check_customer_payment === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_payment', [
                'id' => $this->primaryKey(),
                'order_id' => $this->integer(11)->notNull(),
                'price' => $this->double('16,2')->null()->defaultValue(0)->comment('Tiền thanh toán'),
                'payments' => $this->integer(11)->notNull()->comment('"Loại thanh toán: 0: Thanh toán, 1: Đặt cọc, ..."'),
                'type' => $this->integer(11)->notNull()->comment('"Hình thức thanh toán: 0: Tiền mặt, 1: Chuyển khoản, ..."'),
                'co_so' => $this->integer(11)->null()->comment('Thanh toán lập ở cơ sở nào'),
                'payment_at' => $this->integer(11)->null()->comment('Ngày thanh toán'),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addForeignKey('fk_customer_payment_created_by_user', 'customer_payment', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_payment_updated_by_user', 'customer_payment', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_084142_create_table_customer_payment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_084142_create_table_customer_payment cannot be reverted.\n";

        return false;
    }
    */
}
