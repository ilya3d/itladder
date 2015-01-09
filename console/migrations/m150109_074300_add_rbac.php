<?php

use yii\db\Schema;
use yii\db\Migration;

class m150109_074300_add_rbac extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','role',Schema::TYPE_INTEGER. ' NOT NULL DEFAULT 1');
    }

    public function safeDown()
    {
        $this->dropColumn('user','role',Schema::TYPE_INTEGER);
    }
}
