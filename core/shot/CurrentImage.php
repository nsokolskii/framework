<?php

namespace app\core\shot;

use app\core\Application;

class CurrentImage{
    public function showQuiet($data){
        return sprintf("
        <div class='postimage' style='background-image: url(%s%s);'>
        </div>
        ", 
        '/runtime/img/',
        $data->image
        );
    }

    public function show($data){
        echo $this->showQuiet($data);
    }
}