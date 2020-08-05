<?php

use yii\db\Migration;

/**
 * Class m200617_084131_create_table_customer_order_detail
 */
class m200617_084131_create_table_customer_order_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_customer_order_detail = Yii::$app->db->getTableSchema('customer_order_detail');
        if ($check_customer_order_detail === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_order_detail', [
                'order_detail_id' => $this->primaryKey(),
                'order_id' => $this->integer(11)->notNull(),
                'product_id' => $this->integer(11)->notNull(),
                'qty' => $this->integer(11)->null()->defaultValue(1)->comment('Số lượng'),
                'price' => $this->double('16,2')->null()->defaultValue(0)->comment('Đơn giá'),
                'discount' => $this->double('16,2')->null()->defaultValue(0)->comment('Chiết khấu'),
                'discount_by' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('1: Giảm theo đ, 2: Giảm theo %'),
                'reason_discount' => $this->string(255)->null()->comment('Lý do chiết khấu'),
            ], $tableOptions);
            $this->addForeignKey('fk_customer_order_detail_order_id_customer_order', 'customer_order_detail', 'order_id', 'customer_order', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_customer_order_detail_customer_product_id_customer_product', 'customer_order_detail', 'product_id', 'customer_product', 'id', 'CASCADE', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_084131_create_table_customer_order_detail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_084131_create_table_customer_order_detail cannot be reverted.\n";

        return false;
    }
    */
}
