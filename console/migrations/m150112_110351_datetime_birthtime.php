<?php

use yii\db\Schema;
use yii\db\Migration;

class m150112_110351_datetime_birthtime extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%user}}','birthday',Schema::TYPE_DATETIME.' NOT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('{{%user}}','birthday',Schema::TYPE_INTEGER.' NOT NULL');
    }
}
