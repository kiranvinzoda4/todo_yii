<?php

use yii\db\Migration;

/**
 * Class m230610_084555_user
 */
class m230610_084555_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'started_on' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_on' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s'))
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230610_084555_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230610_084555_user cannot be reverted.\n";

        return false;
    }
    */
}
