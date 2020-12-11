<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel{
    const ROLE_READER = 0;
    const ROLE_AUTHOR = 1;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $role = self::ROLE_READER;
    public string $password = '';
    public string $confirmPassword = '';
    public $data = [];

    public function tableName(): string {
        return 'users';
    }

    public function primaryKey() : string {
        return 'id';
    }

    public function getDisplayName() : string {
        return $this->firstname;
    }

    public function save(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'email']],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => '100']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes() : array{
        return ['firstname', 'lastname', 'email', 'role', 'password'];
    }

    public function populate($id){
        $sql = " WHERE id = $id";
        $this->data = $this->loadFromDb($sql)[0];
    }
}