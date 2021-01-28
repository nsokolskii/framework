<?php

namespace app\core\grid;

class CommentTile{
    public function getTile($tileData){
        return sprintf('
        <div class="comment">
        <div class="username">
        <a href="/user/%s">%s</a> <span class="created_at">%s</span>
        </div>
        %s
        </div>
        ',
        $tileData->author,
        $tileData->nickname,
        $tileData->time_elapsed_string($tileData->created_at),
        $tileData->comment);
    }
}