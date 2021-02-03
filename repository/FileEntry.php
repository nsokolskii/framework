<?php

namespace app\repository;

class FileEntry{
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
        $expl = explode('.', $this->name);
        $ext = strtolower(end($expl));
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