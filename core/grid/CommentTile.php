<?php

namespace app\core\grid;

class CommentTile{
    public function getTile($tileData){
        return sprintf('
        <div class="comment">
        <div class="username">
        <a href="/user/%s">%s</a>
        </div>
        %s
        </div>
        ',
        $tileData->author,
        $tileData->nickname,
        $tileData->comment);
    }
}