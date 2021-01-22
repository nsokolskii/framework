<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller{
    public string $layout = 'main';
    public function handleCheck(Request $request){
        $body = $request->getBody();
    }
    public function check(){
        return Application::$view->renderView('check');
    }
    public function home(){
        $params = [
            'name' => "SomeText"
        ];
        return $this->render('home', $params);
    }
    public function showPost($request, $id){
        Application::$app->model->setTable('shots');
        $post = Application::$app->model->findOne(['id' => $id]);
        Application::$app->model->setTable('comments');
        $comments = Application::$app->model->selectWhere(['post' => $id]);
        $commentForm = new \app\repository\CommentEntry($id);
        if($request->isPost()){
            $commentForm->loadData($request->getBody());
            if($commentForm->validate('post')){
                Application::$app->model->save($commentForm);
                Application::$app->response->redirect("/shots/$id");
            };
        }
        $params = [
            'post' => $post,
            'comments' => $comments,
            'model' => $commentForm,
            'backPath' => '/shots'
        ];
        return $this->render('post', $params);
    }
    public function showGallery(){
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectAll();
        $params = [
            'shots' => $shots
        ];
        return $this->render('browse', $params);
    }
    public function shots($request, $path){
        if($path){
            return $this->showPost($request, $path[0]);
        }
        return $this->showGallery();
    }
    public function user($request, $path){
        if($path){
            $userId = $path[0];
            Application::$app->model->setTable('users');
            $user = Application::$app->model->findOne(['id' => $userId]);
            Application::$app->model->setTable('shots');
            $shots = Application::$app->model->selectWhere(['author' => $user->id]);
            $params = [
                'shots' => $shots,
                'user' => $user->nickname,
            ];
            return $this->render('user', $params);
        }
        else return "No such user";
    }
}
