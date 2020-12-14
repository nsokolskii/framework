<?php

namespace app\models;

use app\core\DbModel;

class CommentBlock extends DbModel{
    public $comments;

    public function tableName(): string {
        return 'comments';
    }

    public function primaryKey() : string {
        return 'id';
    }
    
    public function rules(): array {
        return [];
    }

    public function attributes() : array {
        return ['comments.id', 'comments.author', 'comments.comment', 'comments.upvotes', 'users.nickname'];
    }

    public function populate($id){
        $sql = " LEFT JOIN users ON comments.author = users.id WHERE comments.post = $id";
        $this->comments = $this->loadFromDb($sql);
    }
}