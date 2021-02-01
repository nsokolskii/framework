<?php

namespace app\core\grid;

abstract class Grid{
    
    public abstract function getClass() : string;
    public function show($data, $paginate = 0){
        if(!$paginate){
            echo "<div class='".$this->getClass()."'>";
        }
        $this->generateGrid($data);
        if(!$paginate){
            $this->end();
        }
    }

    public function end(){
        echo "</div>";
    }

    public abstract function getTileClass();

    public function generateGrid($data){
        $tileClass = $this->getTileClass();
        foreach($data as $entry){
            echo $tileClass->getTile($entry);
        }
    }
}