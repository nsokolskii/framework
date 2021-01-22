<?php

namespace app\repository;

use \app\core\Application;

class PostEntry{
    public $author = '';
    public $title = '';
    public $description = '';
    public $image = '';
    public $nickname = '';
    public static $attributes = ['author', 'title', 'description', 'image'];
    public static $primaryKey = 'id';

    public function tableName(): string {
        return 'shots';
    }
    
    public function rules(): array {
        return [];
    }

    public function __construct(){
        $prevTable = Application::$app->model->getTable();
        Application::$app->model->setTable('users');
        $author = Application::$app->model->findOne(['id' => $this->author]);
        $this->nickname = $author->nickname;
        Application::$app->model->setTable($prevTable);
    }
}