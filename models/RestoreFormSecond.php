<?php

namespace app\models;
use app\core\Model;
use app\core\Application;

class RestoreFormSecond extends Model{
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public function rules() : array {
        return [
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => '100']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function updatePassword($restoration){
        $newPassword = password_hash($this->password, PASSWORD_DEFAULT);
        User::alter($restoration->email, 'password', $newPassword);
        return true;
    }
}