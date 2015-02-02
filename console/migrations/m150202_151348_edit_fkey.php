<?php

use yii\db\Schema;
use yii\db\Migration;

class m150202_151348_edit_fkey extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('resource4user', 'resource2user');
        $this->addForeignKey('resource4user', 'resource2user', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->addForeignKey('resource4user', 'resource2user', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');    }
}
