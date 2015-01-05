<?php

use yii\db\Schema;
use yii\db\Migration;

class m150105_093210_add_field_next_position extends Migration
{
    public function safeUp()
    {
        $this->addColumn('position','next_position',Schema::TYPE_INTEGER . ' NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('position','next_position');
    }
}
