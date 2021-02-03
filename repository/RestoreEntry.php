<?php

namespace app\repository;

class RestoreEntry extends FieldEntry{
    public string $email = '';
    public string $hash = '';
    public $classname = 'restore';
    public static $attributes = ['email', 'hash'];
    public static $primaryKey = 'id';

    public function tableName(): string {
        return 'restore';
    }

    public function rules() : array {
        return [];
    }
}