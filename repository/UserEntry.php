<?php

namespace app\repository;

use app\core\Application;

class UserEntry extends FieldEntry{
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
}