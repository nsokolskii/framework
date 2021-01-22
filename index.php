<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "autoloader.php";

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;

$config = [
    'domainName' => 'time.test',
    'model' => \app\repository\MysqlRepository::class,
    'modelClasses' => [
        'shots' => \app\repository\PostEntry::class,
        'users' => \app\repository\User::class,
        'restore' => \app\repository\Restore::class,
        'invites' => \app\repository\Invitation::class,
        'confirmations' => \app\repository\Confirmation::class,
        'comments' => \app\repository\CommentEntry::class
    ],
    'templateClasses' => [
        'comments' => \app\core\grid\CommentGrid::class,
        'browse' => \app\core\grid\BrowseGrid::class,
        'form' => \app\core\form\Form::class
    ],
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=newdb',
        'user' => 'test_user',
        'password' => 'test_pass'
    ]
];

$app = new Application(__DIR__, $config);
$app->router->get('/', [SiteController::class, 'shots']);
$app->router->get('/shots', [SiteController::class, 'shots']);
$app->router->post('/shots', [SiteController::class, 'shots']);
$app->router->get('/user', [SiteController::class, 'user']);

$app->router->get('/verify', [AuthController::class, 'verify']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/restore', [AuthController::class, 'restore']);
$app->router->post('/restore', [AuthController::class, 'restore']);

$app->run();