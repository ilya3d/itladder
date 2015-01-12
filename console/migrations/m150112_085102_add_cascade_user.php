<?php

use yii\db\Schema;
use yii\db\Migration;

class m150112_085102_add_cascade_user extends Migration
{
    public function up()
    {
        $this->dropForeignKey('user4position', 'user2position');
        $this->addForeignKey('user4position', 'user2position', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('user4position', 'user2position');
        $this->addForeignKey('user4position', 'user2position', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }
}
