<?php

namespace app\core\grid;

abstract class Grid{
    
    public abstract function getClass() : string;
    public function show($data){
        $this->generateGrid($data);
    }

    public function begin(){
        echo "<div class='".$this->getClass()."'>";
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