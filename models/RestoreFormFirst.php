<?php

namespace app\models;
use app\core\Model;
use app\core\Application;

class RestoreFormFirst extends Model{
    public string $email = '';
    public function rules() : array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
        ];
    }

    public function restore($hash){
        $user = User::findOne(['email' => $this->email]);
        if(!$user){
            $this->addError('email', 'User with this email does not exist');
            return false;
        }
        $restoration = new Restoration();
        $restoration->saveRestorationEntry($this->email, $hash);
        return true;
    }
}