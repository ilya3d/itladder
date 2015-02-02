<?php

namespace frontend\widgets;

use common\models\Comment;
use common\models\Grid;
use common\models\Group;
use common\models\Post;
use common\models\User;
use frontend\models\CommentForm;
use Yii;
use yii\base\Widget;


class CommentList extends Widget
{

    public $model;
    public $attribute;

    /**
     * @var Post $post
     */
    public $post;

    public function run() {

        $commentForm = new CommentForm();

        if ($commentForm->load(Yii::$app->request->post()) && !Yii::$app->user->getIsGuest()) {

            $comment = new Comment();
            $comment->text = $commentForm->text;
            $comment->user_id = Yii::$app->user->identity->getId();
            $comment->post_id = $this->post->id;

            $comment->created_at = time();
            $comment->updated_at = time();

            $comment->save();
        }

        return $this->render( 'CommentList', [
            'model' => $this->post,
            'commentForm' => $commentForm
        ] );
    }

}