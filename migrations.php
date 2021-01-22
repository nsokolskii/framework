<?php

require_once "autoloader.php";

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

$app->db->applyMigrations();