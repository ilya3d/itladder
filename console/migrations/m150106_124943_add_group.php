<?php

use yii\db\Schema;
use yii\db\Migration;

class m150106_124943_add_group extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('group', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->addColumn('user','group_id',Schema::TYPE_INTEGER);

        $this->addForeignKey('group4users', 'user', 'group_id', 'group', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('group4users','user');
        $this->dropColumn('user','group_id');
        $this->dropTable('group');
    }
}
