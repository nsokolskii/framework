<?php

namespace app\core;

class Controller{
    public string $layout = 'main';
    public function setLayout($layout){
        $this->layout = $layout;
    }
    public function render($view, $params = []){
        $getParamsKeys = array_keys(Application::$app->request->getBody());
        if(Application::$app->request->method() == 'get' && in_array('fetch', $getParamsKeys)){
            ob_start();
            echo Application::$view->renderOnlyView($view, $params);
            $arr = [
                'html' => ob_get_clean()
            ];
            return json_encode($arr);
        }
        return Application::$view->renderView($view, $params);
    }
}