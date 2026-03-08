<?php

use yii\db\Migration;

class m260308_191700_create_book_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);
        $this->addPrimaryKey('pk-book-author', '{{%book_author}}', ['book_id', 'author_id']);
        $this->addForeignKey('fk-book-author-book', '{{%book_author}}', 'book_id', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-book-author-author', '{{%book_author}}', 'author_id', '{{%author}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
    }
}