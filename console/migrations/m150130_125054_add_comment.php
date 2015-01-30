<?php

use yii\db\Schema;
use yii\db\Migration;

class m150130_125054_add_comment extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('comments',
            [
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'text' => Schema::TYPE_TEXT . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
            $tableOptions
        );

        $this->addForeignKey('comment2user', 'comments', 'user_id', 'user', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('comment2post', 'comments', 'post_id', 'post', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
