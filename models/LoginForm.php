<?php

namespace app\models;
use app\core\Model;
use app\core\Application;

class LoginForm extends Model{
    public string $email = '';
    public string $password = '';
    public function rules() : array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function login(){
        $user = User::findOne(['email' => $this->email]);
        if(!$user){
            $this->addError('email', 'User with this email does not exist');
            return false;
        }
        if(!password_verify($this->password, $user->password)){
            var_dump($user);
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        return Application::$app->login($user);
    }
}