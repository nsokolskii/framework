<?php

namespace app\repository;

class ConfirmationEntry extends RestoreEntry{
    public $classname = 'confirmations';
    public function tableName(): string {
        return 'confirmations';
    }
}