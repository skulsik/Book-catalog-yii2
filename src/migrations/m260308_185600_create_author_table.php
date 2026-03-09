<?php

use yii\db\Migration;

class m260308_185600_create_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}