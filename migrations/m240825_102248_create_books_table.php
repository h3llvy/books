<?php

use yii\db\Migration;

class m240825_102248_create_books_table extends Migration
{
    public function safeUp()
    {
        #название, год выпуска, описание, isbn, фото главной страницы
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer(4)->notNull(),
            'description' => $this->text()->notNull(),
            'isbn' => $this->string(13)->notNull(),
            'image' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
