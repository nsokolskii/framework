<?php

namespace app\core\form;

class Field{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public string $type;
    public $model;
    public string $attribute;
    public function __construct($model, $attribute, $type){
        $this->type = !$type ? self::TYPE_TEXT : self::TYPE_PASSWORD;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function labels(){
        return [
            'nickname' => 'Nickname',
            'email' => 'E-mail',
            'invitationCode' => 'Invitation code, if you have one',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
            'comment' => 'Your comment',
            'title' => 'Shot title',
            'description' => 'Shot description',
            'image' => 'Image',
        ];
    }

    public function getField(){
        echo sprintf('
        <div class="form-group">
            <label>%s</label>
            <input type="%s" name="%s" value="%s" class="form-control%s">
            <div class="invalid-feedback">
                %s
            </div>
        </div>
        ', 
        $this->labels()[$this->attribute],
        $this->type, 
        $this->attribute, 
        $this->model->{$this->attribute}, 
        $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        $this->model->getFirstError($this->attribute)
        );
    }
    public function passwordField(){
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}