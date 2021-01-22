<?php

namespace app\core;

class Router{
    public Request $request;
    public Response $response;
    protected array $routes = [];

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
        return call_user_func($callback, $this->request, $subPath);
    }

    
}