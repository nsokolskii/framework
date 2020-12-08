<?php

require_once "core/Application.php";
require_once "core/Model.php";
require_once "controllers/SiteController.php";
require_once "controllers/AuthController.php";
require_once "core/DbModel.php";
require_once "models/User.php";
require_once "core/form/Form.php";
require_once "core/form/Field.php";
require_once "core/Database.php";


use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=newdb',
        'user' => 'test_user',
        'password' => 'test_pass'
    ]
];

$app = new Application(__DIR__, $config);


$app->db->applyMigrations();