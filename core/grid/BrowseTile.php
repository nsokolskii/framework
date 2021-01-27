<?php

namespace app\core\grid;

class BrowseTile{
    public function getTile($tileData){
        return sprintf('
        <a href="/shots/%s"><span class="postWrapper"><div class="postimage" style="opacity: 1; background: linear-gradient(to right, rgba(0,0,0,.2), rgba(0,0,0,.2)), url(%s%s); background-size: cover; background-position: center;">
        <div class="browsetitle">%s</div>
        </div></span></a>
        ',
        $tileData->id,
        '/runtime/img/',
        $tileData->image,
        $tileData->title);
    }
}