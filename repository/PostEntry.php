<?php

namespace app\repository;

use \app\core\Application;

class PostEntry extends FieldEntry{
    public $author = '';
    public $title = '';
    public $description = '';
    public $image = '';
    public $nickname = '';
    public static $attributes = ['author', 'title', 'description', 'image'];
    public string $classname = "shots";
    public static $primaryKey = 'id';

    public function tableName(): string {
        return 'shots';
    }
    
    public function rules(): array {
        return [
            'create' => [
                'title' => [self::RULE_REQUIRED],
                'description' => [self::RULE_REQUIRED]
            ]
        ];
    }

    public function __construct(){
        if($this->author){
            $prevTable = Application::$app->model->getTable();
            Application::$app->model->setTable('users');
            $author = Application::$app->model->findOne(['id' => $this->author]);
            $this->nickname = $author->nickname;
            Application::$app->model->setTable($prevTable);
        }
        else{
            $this->author = Application::isGuest() ? 0 : Application::$app->user->id;
        }
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}