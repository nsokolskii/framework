<?php

namespace app\core\grid;

class UsersTile{
    public function getTile($tileData){
        return sprintf('
        <div class="comment">
        <div class="username">
        <a href="/user/%s">%s</a>
        </div>
        </div>
        ',
        $tileData->id,
        $tileData->nickname);
    }
}