<?php

namespace app\models;

use app\core\DbModel;

class Gallery extends DbModel{
    public $shots = [];

    public function primaryKey() : string {
        return 'id';
    }

    public function tableName(): string {
        return 'shots';
    }
    
    public function rules(): array {
        return [];
    }

    public function attributes() : array {
        return ['id', 'title', 'author', 'image'];
    }

    public function populate(){
        $this->shots = $this->loadFromDb();
    }
}