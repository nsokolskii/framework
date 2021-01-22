<?php

namespace app\core\grid;

class CommentTile{
    public function getTile($tileData){
        return sprintf('
        <div class="comment">
        <div class="username">
        %s
        </div>
        %s
        </div>
        ',
        $tileData->nickname,
        $tileData->comment);
    }
}