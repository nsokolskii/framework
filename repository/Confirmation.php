<?php

namespace app\repository;

class Confirmation extends Restore{
    public $classname = 'confirmations';
    public function tableName(): string {
        return 'confirmations';
    }
}