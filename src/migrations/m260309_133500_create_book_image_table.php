<?php

use yii\db\Migration;

class m260309_133500_create_book_image_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_image}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-book_image-book',
            '{{%book_image}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%book_image}}');
    }
}