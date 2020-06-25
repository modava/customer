<?php

use yii\db\Migration;

/**
 * Class m200608_112240_create_table_customer_agency_origin_hasmany
 */
class m200608_112240_create_table_customer_agency_origin_hasmany extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $check_customer_agency_origin_hasmany = Yii::$app->db->getTableSchema('customer_agency_origin_hasmany');
        if ($check_customer_agency_origin_hasmany === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('customer_agency_origin_hasmany', [
                'agency_id' => $this->integer(11)->notNull(),
                'origin_id' => $this->integer(11)->notNull()
            ], $tableOptions);
            $this->addPrimaryKey('pk_agency_origin_hasmany', 'customer_agency_origin_hasmany', ['agency_id', 'origin_id']);
            $this->addForeignKey('fk_customer_agency_origin_hasmany_agency_id', 'customer_agency_origin_hasmany', 'agency_id', 'customer_agency', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_customer_agency_origin_hasmany_origin_id', 'customer_agency_origin_hasmany', 'origin_id', 'customer_origin', 'id', 'CASCADE', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200608_112240_create_table_customer_agency_origin_hasmany cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_112240_create_table_customer_agency_origin_hasmany cannot be reverted.\n";

        return false;
    }
    */
}
