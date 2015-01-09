<?php

namespace frontend\controllers;

use common\models\Grid;
use common\models\Position;
use common\models\Profession;
use common\models\Resource2position;
use common\models\search\UserSearch;
use common\models\Stage;
use common\models\User;
use common\models\User2position;
use Faker\Factory;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class ProfileController extends DashboardController
{
    public function actionIndex()
    {
        $login =  \Yii::$app->request->getQueryParam('user');
        /** @var User $user */
        $user = User::findByLogin($login);

        if (!$user) throw new NotFoundHttpException('Not found user');

        // todo positions and resource
        $positions = User2position::find()
            ->with( 'position' )
            ->where( ['user_id'=>$user->id, 'status'=>User2position::STATUS_COMPLETE] )
            ->orderBy(['date_change'=>'ASC'])
            ->all();

        $userNextPosition = $user->getCurrentPosition()->next_position;

        $resource = Resource2position::find()
            ->with( ['resource',
                'resource2user' => function ($query) use ($user) {
                    /** @var Query $query */
                    $query->andWhere( ['user_id' => $user->id] );
                }
            ] )
            ->with( 'resource2user' )
            ->where(['position_id'=>$userNextPosition])
            ->all();


        return $this->render('index',['user'=>$user,'positions'=>$positions,'resource'=>$resource]);
    }

    public function generatePosition(){

        User2position::deleteAll();
        Position::deleteAll();

        $grids = Grid::find()->all();
        $stages = Stage::find()->all();

        $i = 1;

        foreach($grids as $grid){

            $position = new Position();

            foreach ($stages as $stage) {
                $position = new Position();
                $position->grid_id = $grid->id;
                $position->stage_id = $stage->id;
                $position->id = $i++;
                $position->next_position = $i;
                $position->save();
            }

            $position->next_position = 0;
            $position->save();

        }


    }

    public function actionGenerate()
    {

        $this->generatePosition();
        User::deleteAll();

        $faker = Factory::create();
        for ($i=1; $i<50; $i++) {


            $user = new User();
            $user->login = $faker->userName;
            $user->username = $faker->name;
            $user->email = $faker->email;
            $user->icq = $faker->numberBetween(10000000, 99999999);
            $user->skype = $faker->word . $faker->randomNumber();
            $user->phone = $faker->phoneNumber;
            $user->address = $faker->address;


            $profession = Profession::findOne(['id' => rand(1, 5)]);
            $user->title_position = $profession->name;
            $user->status = User::STATUS_ACTIVE;

            $user->birthday = $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-20 years')->format('U');
            $user->save();

            $user->link('profession', $profession);


            $user2pos = new User2position();

            $user2pos->user_id = $user->id;
            $user2pos->position_id = rand(1, 24);
            $user2pos->status = User2position::STATUS_COMPLETE;
            $user2pos->date_change = $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now')->format('U');

            $user2pos->save();
        }

    }


    public function actionList()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        /*
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        */

    }

}
