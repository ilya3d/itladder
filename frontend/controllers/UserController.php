<?php

namespace frontend\controllers;

use common\models\Position;
use common\models\Resource2user;
use common\models\User2position;
use Yii;
use common\models\User;
use common\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['user']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['moder']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->grid = (int)Yii::$app->request->getBodyParam('User')['grid'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionRules($id)
    {
        $res2user = new Resource2user();

        if ( $res2user->load( Yii::$app->request->post() ) && $res2user->save() ) {
            return $this->redirect( ['view', 'id' => $id] );
        }

        return $this->render('rules', [
            'model' => $this->findModel($id),
            'res2user' => $res2user
        ]);
    }

    public function actionUppos( $id )
    {

        /** @var User2position $curPos */
        $curPos = User2position::find()
            ->where( ['user_id'=>$id, 'status'=>[User2position::STATUS_IN_PROGRESS,User2position::STATUS_COLLECTED] ] )
            ->limit(1)
            ->one();

        if ( !$curPos ) {

            /** @var User2position $lastPos */
            $lastPos = User2position::find()
                ->where(['user_id'=>$id,'status'=>User2position::STATUS_COMPLETE])
                ->orderBy(['date_change'=>'ASC'])
                ->limit(1)
                ->one();

            if ( !$lastPos )
                return $this->redirect(['view', 'id' => $id]); // todo exception

            /** @var Position $pos */
            $pos = Position::find()->where(['id'=>$lastPos->position_id])->one();

            $curPos = new User2position();
            $curPos->user_id = $id;
            $curPos->position_id = $pos->next_position;
            $curPos->save();
        }



        $curPos->status = 2;
        $curPos->date_change = time();
        $curPos->save();

        // todo not save

        $nextPosId = $curPos->position->next_position;

        if ( $nextPosId ) {
            $nextPos = new User2position();
            $nextPos->user_id = $id;
            $nextPos->position_id = $nextPosId ;
            $nextPos->status = 0;
            $nextPos->date_change = 0;
            $nextPos->save();
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
