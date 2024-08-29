<?php

use yii\db\Migration;

class m240824_170150_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(11)->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->null(),
            'access_token' => $this->string()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
