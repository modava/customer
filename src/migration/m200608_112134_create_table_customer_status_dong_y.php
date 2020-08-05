<?php

use yii\db\Migration;

/**
 * Class m200608_112134_create_table_customer_status_dong_y
 */
class m200608_112134_create_table_customer_status_dong_y extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('customer_status_dong_y');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_status_dong_y', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'description' => $this->text()->null(),
                'status' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('0: disabled, 1: actived'),
                'accept' => $this->tinyInteger(1)->null()->defaultValue(0)->comment('0: không đồng ý, 1: đồng ý'),
                'created_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_at' => $this->integer(11)->null(),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addColumn('customer_status_dong_y', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
            $this->createIndex('index-language', 'customer_status_dong_y', 'language');
            $this->addForeignKey('fk_customer_status_dong_y_created_by_user', 'customer_status_dong_y', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_status_dong_y_updated_by_user', 'customer_status_dong_y', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
        $check_rows = Yii::$app->db->createCommand('SELECT id FROM customer_status_dong_y')->queryOne();
        if ($check_rows === false) {
            $this->execute("INSERT INTO `customer_status_dong_y`(`id`, `name`, `description`, `accept`) VALUES
(1, 'Đồng ý', 'Khách hàng đồng ý làm dịch vụ', 1),
(2, 'Không đồng ý', 'Khách hàng không đồng ý làm dịch vụ', 0),
(3, 'Làm dịch vụ khác', 'Khách hàng cần tư vấn làm dịch vụ khác', 1);");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_112134_create_table_customer_status_dong_y cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_112134_create_table_customer_status_dong_y cannot be reverted.\n";

        return false;
    }
    */
}
