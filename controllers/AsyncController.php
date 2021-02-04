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

    public function routingCheck(){
        $fetch = $_GET['fetch'];
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere([], " ORDER BY created_at DESC ");
        Application::$app->model->fillField($shots, ['users' => ['author', 'nickname']]);
        $grid = Application::$app->templates->browse;
        ob_start();
        $grid->show($shots);
        $arr = [
            'value' => ob_get_clean()
        ];
        return json_encode($arr);
    }

    public function test($request){
        $body = Application::$app->request->jsonGetBody();
        $user = $body['user'];
        $value = $body['value'];
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere(['author' => $user], " ORDER BY created_at ".$this->valueMap[$value]);
        Application::$app->model->fillField($shots, ['users' => ['author', 'nickname']]);
        $grid = Application::$app->templates->browse;
        ob_start();
        $grid->show($shots);
        $arr = array(
            'html' => ob_get_clean()
        );
        return json_encode($arr);
    }

    public function comment($request){
        $body = Application::$app->request->jsonGetBody();
        $comment = new \app\repository\CommentEntry();
        $comment->post = $body['post'];
        if(Application::$app->service->user){
            $comment->comment = $body['value'];
            $comment->author = Application::$app->user->id;
            Application::$app->model->save($comment);
        }
        Application::$app->model->setTable('comments');
        $grid = Application::$app->templates->comments;
        $comments = Application::$app->model->selectWhere(['post' => $comment->post]);
        Application::$app->model->fillField($comments, ['users' => ['author', 'nickname']]);
        ob_start();
        $grid->getCount($comments);
        $grid->begin();
        $grid->show($comments);
        $grid->end();
        $arr = array(
            'html' => ob_get_clean()
        );
        return json_encode($arr);
    }

    public function loadMore($request){
        ob_start();
        $body = Application::$app->request->jsonGetBody();
        $from = $body['from'];
        $limit = $body['limit'];
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere([], " ORDER BY created_at DESC ", [$from, $limit]);
        Application::$app->model->fillField($shots, ['users' => ['author', 'nickname']]);
        $grid = Application::$app->templates->browse;
        $grid->show($shots);
        $arr = array(
            'html' => ob_get_clean(),
            'all' => $limit > count($shots)
        );
        return json_encode($arr);
    }
}