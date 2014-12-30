<?php

use yii\db\Schema;
use yii\db\Migration;

class m141230_134258_user_positions extends Migration  {


    public function safeUp() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('resource', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('position', [
            'id' => Schema::TYPE_PK,
            'grid_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'stage_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('user2position', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date_change' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('resource2position', [
            'resource_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'value' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('resource2user', [
            'resource_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'value' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

    }

    public function safeDown() {

        $this->dropTable('resource');
        $this->dropTable('position');
        $this->dropTable('user2position');
        $this->dropTable('resource2position');
        $this->dropTable('resource2user');

    }
}
