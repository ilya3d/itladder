<?php

use yii\db\Schema;
use yii\db\Migration;

class m150113_125107_add_redmine_id extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','redmine_id',Schema::TYPE_INTEGER.' NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('user','redmine_id');
    }
}
