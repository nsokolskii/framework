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
        $params = [
            'post' => $post,
            'comments' => $comments,
        ];
        return $this->render('post', $params);
    }
    public function showGallery(){
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere([], " ORDER BY created_at DESC ");
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
            $shots = Application::$app->model->selectWhere(['author' => $user->id], " ORDER BY created_at DESC ");
            $params = [
                'shots' => $shots,
                'user' => $user,
            ];
            return $this->render('user', $params);
        }
        else return "No such user";
    }
    public function upload($request){
        if(Application::isGuest() || !Application::$app->user->isAuthor()){
            Application::$app->response->redirect("/");
        }
        $post = new \app\repository\PostEntry();
        $file = new \app\repository\File();
        if($request->isPost()){
            $post->loadData($request->getBody());
            $file->loadData($request->getFiles()['image']);
            if($post->validate('create') && $file->validate()){
                $hash = hash('sha256',date('Y-m-d H:i:s'));
                $imageName = $hash.'.'.$file->getExt();
                move_uploaded_file($file->tmp_name, 'runtime/img/'.$imageName);
                $post->image = $imageName;
                Application::$app->model->save($post);
                Application::$app->response->redirect("/user/".Application::$app->user->id);
            }
        }
        return $this->render('create', [
            'model' => $post,
            'fileModel' => $file
        ]);
    }
}
