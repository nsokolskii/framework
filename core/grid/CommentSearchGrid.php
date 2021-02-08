<?php

namespace app\core\grid;

class CommentSearchGrid extends Grid{
    public function getClass() : string {
        return 'comments';
    }

    public function getTileClass() {
        $tileClass = new CommentSearchTile();
        return $tileClass;
    }

}