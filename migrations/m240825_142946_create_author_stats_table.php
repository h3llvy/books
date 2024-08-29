<?php

use yii\db\Migration;

class m240825_142946_create_author_stats_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%author_stats}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'year' => $this->integer(4)->notNull(),
            'books_count' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-author_stats-author_id',
            'author_stats',
            'author_id',
            'authors',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-author_stats-year-author_id',
            'author_stats',
            ['year', 'author_id'],
            true,
        );

        $this->createIndex(
            'idx-author_stats-year-books_count',
            'author_stats',
            ['year', 'books_count'],
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%author_stats}}');
    }
}
