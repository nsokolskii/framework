<?php

namespace app\core\shot;

use app\core\Application;

class Shot{
    public function show($data){
        echo sprintf("
        <div align='center'>
        <div class='header'>
        <div align='left'>
        <a href='#' onClick='history.go(-1);'>< go back</a>&nbsp;
        %s
        </div>
        </div>
        </div>
        ", 
        Application::$app->user->id == $data->author ? '<a href="/edit/'.$data->id.'" class="btn btn-primary">Edit post</a>' : "");
        echo sprintf("
        <div class='posthead' align='center'>
        <div class='postimage' style='background-image: url(%s%s);'>
        </div>
        <div class='postinfo' align='left'>
        <div class='posttitle'>
        %s
        </div>
        <div class='username'>
        <a href='/user/%s'>%s</a> <span class='created_at'> | %s</span>
        </div>
        <div class='postdesc'>
        %s
        </div>
        </div>
        </div>
        ", 
        '/runtime/img/',
        $data->image,
        $data->title,
        $data->author,
        $data->nickname,
        $data->time_elapsed_string($data->created_at),
        $data->description
        );
    }
}