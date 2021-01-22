<?php

namespace app\repository;

class Restore{
    public string $email = '';
    public string $hash = '';
    public $classname = 'restore';
    public static $attributes = ['email', 'hash'];
    public static $primaryKey = 'id';

    public function loadData($data){
        foreach($data as $key=>$value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function tableName(): string {
        return 'restore';
    }

    public function rules() : array {
        return [];
    }
}