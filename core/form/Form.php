<?php

namespace app\core\form;

class Form{
    public static function begin($action, $method, $enctype = ""){
        echo sprintf('<form action="%s" method="%s" enctype="%s">', $action, $method, $enctype);
    }

    public static function end(){
        echo '</form>';
    }
    
    public function field($model, $attribute, $type = 0){
        $field = new Field($model, $attribute, $type);
        echo $field->getField();
    }
}