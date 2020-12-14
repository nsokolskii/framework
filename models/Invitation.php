<?php

namespace app\models;

use app\core\DbModel;

class Invitation extends DbModel{
    public string $invitationCode = '';

    public function primaryKey() : string {
        return 'id';
    }

    public function tableName(): string {
        return 'invites';
    }
    
    public function rules(): array {
        return [];
    }

    public function attributes() : array {
        return ['id', 'invitationCode'];
    }
}