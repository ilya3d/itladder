<?php

use yii\db\Schema;
use yii\db\Migration;

class m150203_140426_feed extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('feed', [

            'id' => Schema::TYPE_PK,

            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'auth_id' => Schema::TYPE_INTEGER . ' NOT NULL',

            'grid_id' => Schema::TYPE_INTEGER,
            'profession_id' => Schema::TYPE_INTEGER,

            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'value' => Schema::TYPE_STRING . ' NOT NULL',

            'link' => Schema::TYPE_STRING . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' NOT NULL',

            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'level' => Schema::TYPE_INTEGER . ' NOT NULL',

        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('feed');
    }
}
