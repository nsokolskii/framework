<?php

namespace app\core;

class Router{
    public Request $request;
    public Response $response;
    public const RULE_LOGGED_IN = 'logged_in';
    public const RULE_AUTHOR = 'author';
    public const RULE_SHOT_AUTHOR = 'shot_author';
    public const RULE_NON_EMPTY_SUBPATH = 'non_empty_subpath';

    protected array $routes = [];

    protected array $rules = [
        '/upload' => [self::RULE_LOGGED_IN, self::RULE_AUTHOR],
        '/edit' => [self::RULE_NON_EMPTY_SUBPATH, self::RULE_LOGGED_IN, self::RULE_SHOT_AUTHOR],
        '/delete' => [self::RULE_NON_EMPTY_SUBPATH, self::RULE_LOGGED_IN, self::RULE_SHOT_AUTHOR],
        '/comment' => [self::RULE_LOGGED_IN],
        '/user' => [self::RULE_NON_EMPTY_SUBPATH],
        '/verify' => [self::RULE_NON_EMPTY_SUBPATH]
    ];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback){
        $this->routes['post'][$path] = $callback;
    }

    public function grantAccess($page, $subPath = ""){
        if(!in_array($page, array_keys($this->rules))){
            return true;
        }
        foreach($this->rules[$page] as $rule){
            if($rule == self::RULE_LOGGED_IN && Application::$app->service->isGuest()){
                return false;
            }
            if($rule == self::RULE_AUTHOR && !Application::$app->service->isAuthor()){
                return false;
            }
            if($rule == self::RULE_SHOT_AUTHOR){
                Application::$app->model->setTable('shots');
                $shot = Application::$app->model->findOne(['id' => $subPath]);
                if($shot->author != Application::$app->service->userId()){
                    return false;
                }
            }
            if($rule == self::RULE_NON_EMPTY_SUBPATH && !$subPath){
                return false;
            }
        }
        return true;
    }

    public function resolve(){
        $path = $this->request->getPath();
        $subPath = array_slice($path, 2);
        $path = '/'.$path[1];
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            Application::$app->response->setStatusCode(404);
            return "Not found";
            exit;
        }
        if(is_string($callback)){
            return Application::$view->renderView($callback);
        }
        if(is_array($callback)){
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        if($subPath){
            if($this->grantAccess($path, $subPath[0])){
                return call_user_func($callback, $this->request, $subPath);
            }
            else{
                Application::$app->response->redirect("/");
                exit;
            }
        }
        else{
            if($this->grantAccess($path)){
                return call_user_func($callback, $this->request, $subPath);
            }
            else{
                Application::$app->response->redirect("/");
                exit;
            }
        }
    }
}