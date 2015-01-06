<?php

use yii\db\Schema;
use yii\db\Migration;

class m150106_091657_add_pk_res2pos extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `resource2position` ADD PRIMARY KEY( `resource_id`, `position_id`)")->execute();
    }

    public function safeDown()
    {
        $this->db->createCommand("ALTER TABLE resource2position DROP PRIMARY KEY")->execute();
    }
}
