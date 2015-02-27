<?php

use yii\db\Schema;
use yii\db\Migration;

class m150227_100454_post_tags extends Migration
{
    public function up()
    {
        $this->addColumn('post', 'tags', Schema::TYPE_STRING." NOT NULL");
    }

    public function down()
    {
        $this->dropColumn('post','tags');
    }
}
