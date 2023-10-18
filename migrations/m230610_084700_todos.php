<?php

use yii\db\Migration;

/**
 * Class m230610_084700_todos
 */
class m230610_084700_todos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('todos', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'desc' => $this->string()->notNull(),
            'user_id' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'started_on' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_on' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s'))
        ]);

        // create index for column `user_id`
        $this->createIndex(
            'idx-todos-user_id',
            'todos',
            'user_id'
        );

        // add foreign key for table `todos`
        $this->addForeignKey(
            'fk-todo-user_id',
            'todo',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-todos-user_id', 'todos');
        $this->dropIndex('idx-todos-user_id', 'todos');
        $this->dropTable('todos');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230610_084700_todos cannot be reverted.\n";

        return false;
    }
    */
}
