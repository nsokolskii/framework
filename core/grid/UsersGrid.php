<?php

namespace app\core\grid;

class UsersGrid extends Grid{
    public function getClass() : string {
        return 'wrapper';
    }

    public function getTileClass() {
        $tileClass = new UsersTile();
        return $tileClass;
    }

}