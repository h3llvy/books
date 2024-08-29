<?php

use yii\db\Migration;

class m240825_102405_create_author_book_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%author_book}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'PRIMARY KEY(author_id, book_id)',
        ]);

        $this->addForeignKey(
            'fk-author_book-author_id',
            'author_book',
            'author_id',
            'authors',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-author_book-book_id',
            'author_book',
            'book_id',
            'books',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%author_book}}');
    }
}
