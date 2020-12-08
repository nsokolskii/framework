<?php

namespace app\core\grid;

class BrowseGrid extends Grid{
    public function getClass() : string {
        return 'wrapper';
    }

    public function getTileClass() {
        $tileClass = new BrowseTile();
        return $tileClass;
    }

}