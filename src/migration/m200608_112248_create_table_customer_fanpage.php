<?php

use yii\db\Migration;

/**
 * Class m200608_112248_create_table_customer_fanpage
 */
class m200608_112248_create_table_customer_fanpage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $check_customer_fanpage = Yii::$app->db->getTableSchema('customer_fanpage');
        if ($check_customer_fanpage === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_fanpage', [
                'id' => $this->primaryKey(),
                'origin_id' => $this->integer(11)->notNull(),
                'name' => $this->string(255)->notNull(),
                'description' => $this->text()->null(),
                'url_page' => $this->string(255)->null(),
                'status' => $this->tinyInteger(1)->null()->defaultValue(1),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addColumn('customer_fanpage', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
            $this->createIndex('index-language', 'customer_fanpage', 'language');
            $this->addForeignKey('fk_customer_fanpage_created_by_user', 'customer_fanpage', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_fanpage_updated_by_user', 'customer_fanpage', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_fanpage_origin_id_origin', 'customer_fanpage', 'origin_id', 'customer_origin', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_112248_create_table_customer_fanpage cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_112248_create_table_customer_fanpage cannot be reverted.\n";

        return false;
    }
    */
}
