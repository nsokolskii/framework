<?php

require_once "core/Session.php";
require_once "core/Application.php";
require_once "core/Model.php";
require_once "controllers/SiteController.php";
require_once "controllers/AuthController.php";
require_once "core/DbModel.php";
require_once "core/UserModel.php";
require_once "models/User.php";
require_once "core/form/Form.php";
require_once "core/form/Field.php";
require_once "core/grid/Grid.php";
require_once "core/grid/BrowseGrid.php";
require_once "core/grid/BrowseTile.php";
require_once "core/grid/CommentGrid.php";
require_once "core/grid/CommentTile.php";
require_once "core/Database.php";
require_once "models/Gallery.php";
require_once "models/Post.php";
require_once "models/CommentBlock.php";
require_once "models/LoginForm.php";
require_once "models/Invitation.php";
require_once "core/View.php";
require_once "core/Mailer.php";
require_once "models/Confirmation.php";
require_once "models/RestoreFormFirst.php";
require_once "models/RestoreFormSecond.php";
require_once "models/Restoration.php";

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;

$config = [
    'domainName' => 'time.test',
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=newdb',
        'user' => 'test_user',
        'password' => 'test_pass'
    ]
];

$app = new Application(__DIR__, $config);
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/check', [SiteController::class, 'check']);
$app->router->get('/browse', [SiteController::class, 'browse']);
$app->router->post('/check', [SiteController::class, 'handleCheck']);

$app->router->get('/verify', [AuthController::class, 'verify']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/restore', [AuthController::class, 'restore']);
$app->router->post('/restore', [AuthController::class, 'restore']);

$app->run();