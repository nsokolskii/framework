<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller{
    public string $layout = 'main';

    public function showPost($request, $id){
        Application::$app->model->setTable('shots');
        $post = Application::$app->model->findOne(['id' => $id]);
        if($post){
            Application::$app->model->fillField([$post], ['users' => ['author', 'nickname']]);
            Application::$app->model->setTable('comments');
            $comments = Application::$app->model->selectWhere(['post' => $id]);
            Application::$app->model->fillField($comments, ['users' => ['author', 'nickname']]);
            $params = [
                'post' => $post,
                'comments' => $comments,
            ];
            return $this->render('post', $params);
        }
        Application::$app->response->redirect("/shots");
    }

    public function showGallery(){
        Application::$app->model->setTable('shots');
        $shots = Application::$app->model->selectWhere([], " ORDER BY created_at DESC ");
        Application::$app->model->fillField($shots, ['users' => ['author', 'nickname']]);
        $params = [
            'shots' => $shots
        ];
        Application::$app->session->set('backRoute', '/shots');
        return $this->render('browse', $params);
    }

    public function shots($request, $path){
        if($path){
            return $this->showPost($request, $path[0]);
        }
        return $this->showGallery();
    }

    public function user($request, $path){
        $userId = $path[0];
        Application::$app->model->setTable('users');
        $user = Application::$app->model->findOne(['id' => $userId]);
        if($user){
            Application::$app->model->setTable('shots');
            $shots = Application::$app->model->selectWhere(['author' => $user->id], " ORDER BY created_at DESC ");
            Application::$app->model->fillField($shots, ['users' => ['author', 'nickname']]);
            $params = [
                'shots' => $shots,
                'user' => $user,
            ];
            Application::$app->session->set('backRoute', '/user/'.$userId);
            return $this->render('user', $params);
        }
        else Application::$app->response->redirect("/");
    }

    public function search($request, $path){
        $searchField = new \app\repository\SearchEntry();
        if($request->isPost()){
            $searchField->loadData($request->getBody());
            $query = $searchField->query;
        }
        else{
            $query = $path[0] ?? "";
        }
        Application::$app->model->setTable('shots');
        $result = Application::$app->model->search(['shots', 'users', 'comments'], 
        ['query' => $query, 'attributes' => ['shots' => ['title', 'description'], 'users' => ['nickname'], 'comments' => ['comment']]], ' ORDER BY created_at DESC LIMIT 12 ');
        if(in_array('shots', array_keys($result))){
            Application::$app->model->fillField($result['shots'], ['users' => ['author', 'nickname']]);
        }
        if(in_array('comments', array_keys($result))){
            Application::$app->model->fillField($result['comments'], ['users' => ['author', 'nickname']]);
            Application::$app->model->fillField($result['comments'], ['shots' => ['post', 'title']]);
        }
        $params = [
            'shots' => $result['shots'] ?? null,
            'users' => $result['users'] ?? null,
            'comments' => $result['comments'] ?? null,
            'model' => $searchField
        ];
        return $this->render('search', $params);
    }
}
