<?php

use yii\db\Migration;

/**
 * Class m200617_084111_create_table_comment
 */
class m200617_084111_create_table_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_comment = Yii::$app->db->getTableSchema('comment');
        if ($check_comment === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('comment', [
                'id' => $this->primaryKey(),
                'table_name' => $this->string(255)->notNull()->comment('Comment cho bảng nào'),
                'table_id' => $this->integer(11)->notNull()->comment('Comment cho dòng nào'),
                'comment' => $this->string(255)->notNull()->comment('Nội dung comment'),
                'created_at' => $this->integer(11)->null(),
                'created_by' => $this->integer(11)->null()->defaultValue(1),
            ], $tableOptions);
            $this->addForeignKey('fk_comment_created_by_user', 'comment', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_084111_create_table_comment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_084111_create_table_comment cannot be reverted.\n";

        return false;
    }
    */
}
