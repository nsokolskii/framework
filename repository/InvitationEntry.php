<?php

namespace app\repository;

class InvitationEntry extends FieldEntry{
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