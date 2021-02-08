<?php

namespace app\repository;

use app\core\Application;

class SearchEntry extends FieldEntry{
    public $query = '';
    public function rules() : array {
        return [];
    }
}