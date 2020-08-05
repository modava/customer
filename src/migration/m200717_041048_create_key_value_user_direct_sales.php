<?php

use yii\db\Migration;

/**
 * Class m200717_041048_create_key_value_user_direct_sales
 */
class m200717_041048_create_key_value_user_direct_sales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $check = Yii::$app->db->createCommand("SELECT * FROM `website_key_value` WHERE `key`='ROLE_DIRECT_SALES'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `website_key_value` (`title`, `key`, `value`, `status`, `language`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('Role Direct Sales', 'ROLE_DIRECT_SALES', 'direct_sales', 1, '', 1594893389, 1594893389, 1, 1)");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200717_041048_create_key_value_user_direct_sales cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200717_041048_create_key_value_user_direct_sales cannot be reverted.\n";

        return false;
    }
    */
}
