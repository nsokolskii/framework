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
    
    public function rules(): array {
        return [];
    }

    public function attributes() : array {
        return ['id', 'author', 'title', 'description', 'image'];
    }

    public function populate($id){
        $sql = " WHERE id = $id";
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