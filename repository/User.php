<?php

namespace app\repository;

use app\core\Application;

class User extends FieldEntry{
    const ROLE_READER = 0;
    const ROLE_AUTHOR = 1;
    public string $nickname = '';
    public string $email = '';
    public int $role = self::ROLE_READER;
    public string $password = '';
    public string $confirmPassword = '';
    public string $invitationCode = '';
    public int $confirmed = 0;
    public string $classname = 'users';
    public static $attributes = ['nickname', 'email', 'role', 'password', 'confirmed'];
    public static $primaryKey = 'id';

    public function rules(): array {
        return [
            'register' => [
                'nickname' => [self::RULE_REQUIRED],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                    self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'email']],
                'invitationCode' => [self::RULE_INVITED],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => '100']],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
            ],
            'login' => [
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'password' => [self::RULE_REQUIRED]
            ],
            'restore1' => [
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
            ],
            'restore2' => [
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => '100']],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
            ]
        ];
    }

    public function tableName(): string {
        return 'users';
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
        $confirmation = new Confirmation();
        $hash = $params['hash'];
        $confirmation->loadData([
            'email' => $this->email,
            'hash' => $hash
        ]);
        Application::$app->model->save($confirmation);
        Application::$app->model->save($this);
        return $hash;
    }

    public function login(){
        Application::$app->model->setTable('users');
        $user = Application::$app->model->findOne(['email' => $this->email]);
        if(!$user){
            $this->addError('email', 'User with this email does not exist');
            return false;
        }
        if(!password_verify($this->password, $user->password)){
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }

    public function restore($hash){
        Application::$app->model->setTable('users');
        $user = Application::$app->model->findOne(['email' => $this->email]);
        if(!$user){
            $this->addError('email', 'User with this email does not exist');
            return false;
        }
        $restoration = new Restore();
        $restoration->loadData([
            'email' => $this->email,
            'hash' => $hash
        ]);
        Application::$app->model->save($restoration);
        return true;
    }

    public function updatePassword($restoration){
        Application::$app->model->setTable('users');
        $newPassword = password_hash($this->password, PASSWORD_DEFAULT);
        Application::$app->model->alterOne(['email' => $restoration->email], ['password' => $newPassword]);
        return true;
    }
}