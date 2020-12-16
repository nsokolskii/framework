<?php

namespace app\models;

use app\core\DbModel;

class Confirmation extends DbModel{
    public string $email = '';
    public string $confirmationCode = '';

    public function tableName(): string {
        return 'confirmations';
    }

    public function primaryKey() : string {
        return 'id';
    }

    public function rules() : array {
        return [];
    }

    public function attributes(): array {
        return ['email', 'confirmationCode'];
    }

    public function saveConfirmationCode($email, $confirmationCode){
        $this->email = $email;
        $this->confirmationCode = $confirmationCode;
        return parent::save();
    }

}