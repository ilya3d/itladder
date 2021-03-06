<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Grid;
use common\models\Position;
use common\models\Post;
use common\models\Profession;
use common\models\Resource2position;
use common\models\search\UserSearch;
use common\models\Stage;
use common\models\User;
use common\models\User2position;
use Faker\Factory;
use frontend\models\CommentForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BlogController extends Controller
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
                        'actions'=>['index','view','list','edit-comment'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','create','delete'],
                        'matchCallback'=>function(){
                            $params = Yii::$app->getRequest()->getQueryParams();
                            if (!isset($params['user'])) return false;

                            $user = User::findByLogin($params['user']);
                            if (!$user) return false;

                            if (!\Yii::$app->user->can('updateOwnProfile', ['profileId' => $user->id])) {
                                return false;
                            }
                            return true;
                        }
                    ],
                ]
            ]
        ];
    }

    public function actionList()
    {
        $query = Post::find();

        $tag = Yii::$app->request->get('tag','');
        if ($tag){
            $query->andWhere(['like', 'tags', $tag]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {
        $id =  \Yii::$app->request->getQueryParam('id');
        $login =  \Yii::$app->request->getQueryParam('user');

        $commentForm = new CommentForm();
        if (!$id) throw new NotFoundHttpException();

        $post = $this->findModel($id);
        if ($post->user->login!=$login) throw new NotFoundHttpException();



        return $this->render('view', [
            'model' => $post,
            'commentForm' => $commentForm
        ]);

    }

    public function actionIndex()
    {

        $login =  \Yii::$app->request->getQueryParam('user');
        $user = User::findByLogin($login);

        if (!$user) throw new NotFoundHttpException();

        $query = Post::find()->where(['user_id'=>$user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->user_id = Yii::$app->getUser()->getIdentity()->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['blog/view', 'id' => $model->id, 'user'=> $model->user->login]);
        } else {
            return $this->render('@app/views/post/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        $model->user_id = Yii::$app->getUser()->getIdentity()->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['blog/view', 'id' => $model->id,'user'=> $model->user->login]);
        } else {
            return $this->render('@app/views/post/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $post = $this->findModel($id);
        $login = $post->user->login;
        $this->findModel($id)->delete();

        return $this->redirect(['index','user'=> $login]);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEditComment()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $val = Yii::$app->request->post('val');
            $comment_id = Yii::$app->request->post('comment_id');

            $comment = Comment::findOne(['id'=>$comment_id,'user_id'=>Yii::$app->user->getId()]);
            if (!$comment) {
                throw new NotFoundHttpException('not found');
            }

            $comment->text = $val;
            $comment->updated_at = time();
            $comment->save();

            return $res = ['text'=>$comment->text];
        }
    }


}
