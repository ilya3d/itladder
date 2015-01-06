<?php

use yii\db\Schema;
use yii\db\Migration;

class m150106_135304_add_pk_res2user extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `resource2user` ADD PRIMARY KEY( `resource_id`, `user_id`)")->execute();
    }

    public function safeDown()
    {
        $this->db->createCommand("ALTER TABLE resource2user DROP PRIMARY KEY")->execute();
    }
}
