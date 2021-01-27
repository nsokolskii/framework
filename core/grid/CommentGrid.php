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

    public function getCount($comments){
        $n = count($comments);
        $postfix = ($n == 1) ? '' : 's';
        if($n){
            echo sprintf('<div align="center"><div class="header" align="left">%s comment%s:</div></div>', $n, $postfix);
        }
        else echo '<div align="center"><div class="header" align="left">No comments yet</div></div>';
    }

}