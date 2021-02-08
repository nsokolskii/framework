<?php

namespace app\repository;

use \app\core\Application;

class CommentEntry extends FieldEntry{
    public $author = '';
    public $nickname = '';
    public $comment = '';
    public $created_at = '';
    public $post = '';
    public $title = '';
    public $upvotes = 0;
    public string $classname = 'comments';
    public static $attributes = ['post', 'author', 'comment', 'upvotes', 'created_at'];
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
}