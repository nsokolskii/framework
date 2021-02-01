<?php

namespace app\repository;

class File{
    public $name = '';
    public $type = '';
    public $tmp_name = '';
    public $error = '';
    public $size = '';
    public $ext = '';
    public $allowedTypes = ['jpg', 'jpeg', 'png'];
    public $errors = [];

    public function loadData($data){
        foreach($data as $key=>$value){
            if(property_exists($this, $key)){
                
                $this->{$key} = $value;
            }
        }
    }

    public function getExt(){
        $ext = strtolower(end(explode('.', $this->name)));
        return $ext;
    }

    public function empty(){
        if($this->error == 4){
            return true;
        }
    }

    public function validate(){
        if($this->empty()){
            return true;
        }
        if(in_array($this->getExt(), $this->allowedTypes)){
            return true;
        }
        else $this->errors[] = "Allowed picture types are: ".implode(", ", $this->allowedTypes);
    }

    public function getError(){
        if($this->errors){
            return end($this->errors);
        }
    }
}