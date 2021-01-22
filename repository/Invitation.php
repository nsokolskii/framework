<?php

namespace app\repository;

class Invitation{
    public string $invitationCode = '';
    public static $attributes = ['invitationCode'];
    public static $primaryKey = 'id';
    public $classname = 'invites';

    public function tableName(): string {
        return 'invites';
    }
    
    public function rules(): array {
        return [];
    }

}