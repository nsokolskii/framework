<?php

namespace app\core\grid;

class BrowseTile{
    public function getTile($tileData){
        return sprintf('
        <a href="/shots/%s"><div class="postimage" style="background: linear-gradient(to right, rgba(0,0,0,.2), rgba(0,0,0,.2)), url(%s%s); background-size: cover; background-position: center;">
        <div class="browsetitle">%s</div>
        </div></a>
        ',
        $tileData->id,
        '/runtime/img/',
        $tileData->image,
        $tileData->title);
    }
}