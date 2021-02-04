<?php

namespace app\core;

class Request{
    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = trim($path, '/');
        $path = '/'.$path;
        $pos = strpos($path, '?');
        $parsedPath = explode('/', $path);
        if($pos === false){
            return $parsedPath;
        }
        
        return explode('/', substr($path, 0, $pos));
    }
    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet(){
        return $this->method() === 'get';
    }
    public function isPost(){
        return $this->method() === 'post';
    }
    public function getBody(){
        $body = [];
        if($this->method() === 'get'){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->method() === 'post'){
            foreach ($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
    public function jsonGetBody(){
        $_POST = json_decode(file_get_contents('php://input'), true);
        $body = [];
        if($this->method() === 'post'){
            foreach ($_POST as $key => $value){
                $body[$key] = $value;
            }
        }
        return $body;
    }
    public function getFiles(){
        $body = [];
        foreach($_FILES as $key => $value){
            $body[$key] = $value;
        }
        return $body;
    }
}