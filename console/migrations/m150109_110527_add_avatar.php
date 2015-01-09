<?php

use yii\db\Schema;
use yii\db\Migration;

class m150109_110527_add_avatar extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','photo',Schema::TYPE_STRING.' NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('user','photo');
    }
}
