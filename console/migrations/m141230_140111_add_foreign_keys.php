<?php

use yii\db\Schema;
use yii\db\Migration;

class m141230_140111_add_foreign_keys extends Migration {

    public function safeUp() {

        $this->addForeignKey('profession4users', '{{%user}}', 'profession_id', 'profession', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('grid4position', 'position', 'grid_id', 'grid', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('stage4position', 'position', 'stage_id', 'stage', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('position4user', 'user2position', 'position_id', 'position', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user4position', 'user2position', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('resource4user', 'resource2user', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user4resource', 'resource2user', 'resource_id', 'resource', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('resource4position', 'resource2position', 'resource_id', 'resource', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('position4resource', 'resource2position', 'position_id', 'position', 'id', 'RESTRICT', 'RESTRICT');

    }

    public function safeDown() {

        $this->dropForeignKey('profession4users', '{{%user}}');

        $this->dropForeignKey('grid4position', 'position');
        $this->dropForeignKey('stage4position', 'position');

        $this->dropForeignKey('position4user', 'user2position');
        $this->dropForeignKey('user4position', 'user2position');

        $this->dropForeignKey('resource4user', 'resource2user');
        $this->dropForeignKey('user4resource', 'resource2user');

        $this->dropForeignKey('resource4position', 'resource2position');
        $this->dropForeignKey('position4resource', 'resource2position');

    }
}
