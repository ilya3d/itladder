<?php

namespace frontend\widgets;

use common\models\Comment;
use Yii;
use yii\base\Widget;


class CommentView extends Widget
{

    public $model;
    public $attribute;

    /**
     * @var Comment $post
     */
    public $comment;

    public function run() {
        return $this->render( 'CommentView', [
            'comment' => $this->comment,
        ] );
    }

}