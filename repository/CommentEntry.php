<?php

namespace app\repository;

use \app\core\Application;

class CommentEntry extends FieldEntry{
    public $author = '';
    public $nickname = '';
    public $comment = '';
    public $post = '';
    public $upvotes = 0;
    public string $classname = 'comments';
    public static $attributes = ['post', 'author', 'comment', 'upvotes'];
    public static $primaryKey = 'id';

    public function tableName(): string {
        return 'comments';
    }
    
    public function rules(): array {
        return [
            'post' => [
                'comment' => [self::RULE_REQUIRED]
            ]
        ];
    }

    public function __construct($postId = ''){
        if($this->author){
            $prevTable = Application::$app->model->getTable();
            Application::$app->model->setTable('users');
            $author = Application::$app->model->findOne(['id' => $this->author]);
            $this->nickname = $author->nickname;
            Application::$app->model->setTable($prevTable);
        }
        else{
            $this->author = Application::isGuest() ? 0 : Application::$app->user->id;
            $this->post = $postId;
        }
    }

}