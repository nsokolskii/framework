<?php

namespace app\core\grid;

class CommentGrid extends Grid{
    public function getClass() : string {
        return 'comments';
    }

    public function getTileClass() {
        $tileClass = new CommentTile();
        return $tileClass;
    }

}