<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class AsyncController extends Controller{
    public $valueMap = [
        'ascending' => '',
        'descending' => 'DESC'
    ];

    public function test($request){
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere(['author' => $_POST['page']], " ORDER BY created_at ".$this->valueMap[$_POST['value']]);
        $grid = Application::$app->templates->browse;
        return $grid->show($shots)."</div>";
    }

    public function comment($request){
        $comment = new \app\repository\CommentEntry();
        $comment->comment = $_POST['value'];
        $comment->post = $_POST['page'];
        Application::$app->model->save($comment);
        Application::$app->model->setTable('comments');
        $grid = Application::$app->templates->comments;
        $comments = Application::$app->model->selectWhere(['post' => $comment->post]);
        $grid->getCount($comments);
        return $grid->show($comments);
    }

    public function loadMore($request){
        $_POST = json_decode(file_get_contents('php://input'), true);
        $limit = $_POST['limit'];
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere([], " ORDER BY created_at DESC ", [0, $limit]);
        $grid = Application::$app->templates->browse;
        ob_start();
        $grid->show($shots);
        $arr = array(
            'html' => ob_get_clean(),
            'all' => $limit > count($shots)
        );
        return json_encode($arr);
    }
}