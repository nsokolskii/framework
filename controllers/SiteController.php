<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Gallery;
use app\models\Post;
use app\models\CommentBlock;
use app\models\User;

class SiteController extends Controller{
    public string $layout = 'main';
    public function handleCheck(Request $request){
        $body = $request->getBody();
        var_dump($body);
    }
    public function check(){
        return Application::$app->router->renderView('check');
    }
    public function home(){
        $params = [
            'name' => "SomeText"
        ];
        return $this->render('home', $params);
    }
    public function showPost($id){
        $post = new Post();
        $commentBlock = new CommentBlock();
        $post->populate($id);
        $commentBlock->populate($id);
        $params = [
            'post' => $post->shot,
            'comments' => $commentBlock->comments
        ];
        return $this->render('post', $params);
    }
    public function showGallery(){
        $gallery = new Gallery();
        $gallery->populate();
        $params = [
            'shots' => $gallery->shots
        ];
        return $this->render('browse', $params);
    }
    public function browse($request, $path){
        if($path){
            return $this->showPost($path[0]);
        }
        return $this->showGallery();
    }
}
