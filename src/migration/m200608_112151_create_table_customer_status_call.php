<?php

use yii\db\Migration;

/**
 * Class m200608_112151_create_table_customer_status_call
 */
class m200608_112151_create_table_customer_status_call extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('customer_status_call');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_status_call', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'description' => $this->text()->null(),
                'status' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('0: disabled, 1: actived'),
                'accept' => $this->tinyInteger(1)->null()->defaultValue(0)->comment('0: không đặt hẹn, 1: đặt hẹn'),
                'created_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_at' => $this->integer(11)->null(),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addColumn('customer_status_call', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
            $this->createIndex('index-language', 'customer_status_call', 'language');
            $this->addForeignKey('fk_customer_status_call_created_by_user', 'customer_status_call', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_call_updated_by_user', 'customer_status_call', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
        $check_rows = Yii::$app->db->createCommand('SELECT id FROM customer_status_call')->queryOne();
        if ($check_rows === false) {
            $this->execute("INSERT INTO `customer_status_call`(`id`, `name`, `description`, `accept`) VALUES
(1, 'Fail', 'Khách hàng fail', 0),
(2, 'Đặt hẹn', 'Khách hàng đặt hẹn', 1);");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_112151_create_table_customer_status_call cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_112151_create_table_customer_status_call cannot be reverted.\n";

        return false;
    }
    */
}
