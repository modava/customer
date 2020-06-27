<?php

use yii\db\Migration;

/**
 * Class m200609_114518_create_table_customer_co_so
 */
class m200609_114518_create_table_customer_co_so extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('customer_co_so');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_co_so', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->null(),
                'address' => $this->string(255)->null(),
                'phone' => $this->string(255)->null(),
                'email' => $this->string(255)->null(),
                'description' => $this->string(255)->null(),
                'status' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('0:disabled, 1:activated'),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
                'updated_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addColumn('customer_co_so', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language' AFTER `status`");
            $this->createIndex('index-language', 'customer_co_so', 'language');
            $this->addForeignKey('fk_customer_co_so_created_by_user', 'customer_co_so', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
            $this->addForeignKey('fk_customer_co_so_updated_by_user', 'customer_co_so', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200609_114518_create_table_customer_co_so cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200609_114518_create_table_customer_co_so cannot be reverted.\n";

        return false;
    }
    */
}
