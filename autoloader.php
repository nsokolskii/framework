<?php

spl_autoload_register(function($className){
    $className = explode('\\', $className);
    array_shift($className);
    $className = implode('\\', $className);
    include dirname(__FILE__).'/'.str_replace('\\', '/', $className).'.php';
});