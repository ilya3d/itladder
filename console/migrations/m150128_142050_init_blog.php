<?php

use yii\db\Schema;
use yii\db\Migration;

class m150128_142050_init_blog extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('post', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'announce' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ],$tableOptions);

        $this->addForeignKey('post2user', 'post', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('post');
    }
}
