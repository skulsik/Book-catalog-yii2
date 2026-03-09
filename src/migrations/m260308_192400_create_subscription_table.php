<?php

use yii\db\Migration;

class m260308_192400_create_subscription_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(32)->notNull(),
            'created_at' => $this->integer(),
        ]);
        $this->addForeignKey('fk-subscription-author', '{{%subscription}}', 'author_id', '{{%author}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}