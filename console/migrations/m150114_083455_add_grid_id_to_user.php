<?php

use yii\db\Schema;
use yii\db\Migration;

class m150114_083455_add_grid_id_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user','grid_id',Schema::TYPE_INTEGER." NOT NULL");
        $users = \common\models\User::find()->all();

        foreach($users as $user){
            /** @var \common\models\Position $position */

            $position = $user->getPositions()->one();
            if (!$position) continue;

            $user->setAttribute('grid_id',$position->grid_id);
            $user->save();
        }

    }

    public function down()
    {
        $this->dropColumn('user','grid_id');
    }
}
