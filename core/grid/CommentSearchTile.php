<?php

namespace app\core\grid;

class CommentSearchTile extends CommentTile{
    public function getTile($tileData){
        return sprintf('<div class="commentSearchWrapper"><a href="/shots/%s">Go to post <span class="commentSearchTitle">%s</span></a>%s</div>
        ',
        $tileData->post,
        $tileData->title,
        parent::getTile($tileData));
    }
}