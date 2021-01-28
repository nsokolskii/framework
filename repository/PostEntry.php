<?php

namespace app\repository;

use \app\core\Application;

class PostEntry extends FieldEntry{
    public $author = '';
    public $title = '';
    public $description = '';
    public $image = '';
    public $nickname = '';
    public $created_at = '';
    public static $attributes = ['author', 'title', 'description', 'image', 'created_at'];
    public string $classname = "shots";
    public static $primaryKey = 'id';

    public function tableName(): string {
        return 'shots';
    }
    
    public function rules(): array {
        return [
            'create' => [
                'title' => [self::RULE_REQUIRED],
                'description' => [self::RULE_REQUIRED]
            ]
        ];
    }

    public function __construct(){
        if($this->author){
            $prevTable = Application::$app->model->getTable();
            Application::$app->model->setTable('users');
            $author = Application::$app->model->findOne(['id' => $this->author]);
            $this->nickname = $author->nickname;
            Application::$app->model->setTable($prevTable);
        }
        else{
            $this->author = Application::isGuest() ? 0 : Application::$app->user->id;
        }
    }

    
}