<?php

namespace app\models;

use app\core\DbModel;

class Restoration extends DbModel{
    public string $email = '';
    public string $hash = '';

    public function tableName(): string {
        return 'restore';
    }

    public function primaryKey() : string {
        return 'id';
    }

    public function rules() : array {
        return [];
    }

    public function attributes(): array {
        return ['email', 'hash'];
    }

    public function saveRestorationEntry($email, $hash){
        $this->email = $email;
        $this->hash = $hash;
        return parent::save();
    }

}