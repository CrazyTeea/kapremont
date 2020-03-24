<?php

namespace app\controllers\api;

use app\models\Comments;
use yii\rest\ActiveController;
use yii\web\UrlRuleInterface;

class CommentController extends ActiveController implements UrlRuleInterface
{
    public $modelClass = Comments::class;
    
    public function createUrl($manager, $route, $params)
    {
    }

    public function parseRequest($manager, $request)
    {
    }
}