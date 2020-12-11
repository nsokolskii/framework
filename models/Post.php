<?php

namespace app\models;

use app\core\DbModel;
use app\core\Application;

use \PDOException;

class Post extends DbModel{
    public $shot;

    public function tableName(): string {
        return 'shots';
    }

    public function primaryKey() : string {
        return 'id';
    }
    
    public function rules(): array {
        return [];
    }

    public function attributes() : array {
        return ['shots.id', 'shots.author', 'shots.title', 'shots.description', 'shots.image', 'users.firstname'];
    }

    public function populate($id){
        $sql = " LEFT JOIN users ON shots.author = users.id WHERE shots.id = $id";
        try{
            $this->shot = $this->loadFromDb($sql)[0];
        }
        catch(PDOException $e){
            Application::$app->response->setStatusCode(404);
            echo "Not found";
            exit;
        }
    }
}