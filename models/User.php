<?php

namespace app\models;

use app\core\UserModel;
use app\core\Application;

class User extends UserModel{
    const ROLE_READER = 0;
    const ROLE_AUTHOR = 1;
    public string $nickname = '';
    public string $email = '';
    public int $role = self::ROLE_READER;
    public string $password = '';
    public string $confirmPassword = '';
    public string $invitationCode = '';
    public int $confirmed = 0;
    public $data = [];

    public function tableName(): string {
        return 'users';
    }

    public function primaryKey() : string {
        return 'id';
    }

    public function isAuthor(){
        return $this->role;
    }

    public function isConfirmed(){
        return $this->confirmed;
    }

    public function getDisplayName() : string {
        return $this->nickname;
    }

    public function save($params = []){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        if(array_search('invitationCode', $params['validated']) !== false){
            $this->role = self::ROLE_AUTHOR;
        }
        return parent::save();
    }

    public function rules(): array {
        return [
            'nickname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'email']],
            'invitationCode' => [self::RULE_INVITED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => '100']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes() : array{
        return ['nickname', 'email', 'role', 'password', 'confirmed'];
    }

    public function populate($id){
        $sql = " WHERE id = $id";
        $this->data = $this->loadFromDb($sql)[0];
    }

    public static function alter($key, $field, $value){
        $sql = "UPDATE users SET $field = '$value' WHERE email = '$key'";
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
    }
}