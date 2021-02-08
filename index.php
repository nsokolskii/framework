<?php
require_once "autoloader.php";

use app\controllers\SiteController;
use app\controllers\AsyncController;
use app\controllers\EditController;
use app\controllers\AuthController;
use app\core\Application;

$config = [
    'domainName' => 'time.test',
    'userClass' => \app\repository\UserEntry::class,
    'model' => \app\repository\MysqlRepository::class,
    'modelClasses' => [
        'shots' => \app\repository\PostEntry::class,
        'users' => \app\repository\UserEntry::class,
        'restore' => \app\repository\RestoreEntry::class,
        'invites' => \app\repository\InvitationEntry::class,
        'confirmations' => \app\repository\ConfirmationEntry::class,
        'comments' => \app\repository\CommentEntry::class
    ],
    'templateClasses' => [
        'comments' => \app\core\grid\CommentGrid::class,
        'browse' => \app\core\grid\BrowseGrid::class,
        'users' => \app\core\grid\UsersGrid::class,
        'form' => \app\core\form\Form::class,
        'shot' => \app\core\shot\Shot::class,
        'currentImage' => \app\core\shot\CurrentImage::class
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
$app->router->get('/create', [SiteController::class, 'create']);
$app->router->post('/create', [SiteController::class, 'create']);
$app->router->get('/upload', [EditController::class, 'upload']);
$app->router->post('/upload', [EditController::class, 'upload']);
$app->router->get('/search', [SiteController::class, 'search']);
$app->router->post('/search', [SiteController::class, 'search']);
$app->router->get('/edit', [EditController::class, 'edit']);
$app->router->get('/delete', [EditController::class, 'delete']);
$app->router->post('/edit', [EditController::class, 'edit']);
$app->router->post('/test', [AsyncController::class, 'test']);
$app->router->post('/comment', [AsyncController::class, 'comment']);
$app->router->post('/loadMore', [AsyncController::class, 'loadMore']);
$app->router->get('/routingCheck', [AsyncController::class, 'routingCheck']);

$app->router->get('/verify', [AuthController::class, 'verify']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/restore', [AuthController::class, 'restore']);
$app->router->post('/restore', [AuthController::class, 'restore']);

$app->run();