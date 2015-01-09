<?php

use yii\db\Schema;
use yii\db\Migration;

class m150109_091209_add_pk_user2pos extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `user2position` ADD PRIMARY KEY( `position_id`, `user_id`)")->execute();
    }

    public function safeDown()
    {
        $this->db->createCommand("ALTER TABLE user2position DROP PRIMARY KEY")->execute();
    }
}
