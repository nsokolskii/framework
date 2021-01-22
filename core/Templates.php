<?php

namespace app\core;

class Templates{
    public function __construct($classes = []){
        foreach($classes as $key => $value){
            $this->{$key} = new $value();
        }
    }
}