<?php

use yii\db\Migration;

/**
 * Class m200608_112119_create_table_customer_status_fail
 */
class m200608_112119_create_table_customer_status_fail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('customer_status_fail');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_status_fail', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'description' => $this->text()->null(),
                'status' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('0: disabled, 1: actived'),
                'created_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_at' => $this->integer(11)->null(),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addColumn('customer_status_fail', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
            $this->createIndex('index-language', 'customer_status_fail', 'language');
            $this->addForeignKey('fk_customer_status_fail_created_by_user', 'customer_status_fail', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_fail_updated_by_user', 'customer_status_fail', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
        $check_rows = Yii::$app->db->createCommand('SELECT id FROM customer_status_fail')->queryOne();
        if ($check_rows === false) {
            $this->execute("INSERT INTO `customer_status_fail`(`id`, `name`, `description`) VALUES
(1, 'KBM', 'Khách hàng không bắt máy'),
(2, 'Ở xa', 'Khách hàng ở xa không tiện đến'),
(3, 'Có con nhỏ', 'Khách hàng có con nhỏ không đến được');");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_112119_create_table_customer_status_fail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_112119_create_table_customer_status_fail cannot be reverted.\n";

        return false;
    }
    */
}
