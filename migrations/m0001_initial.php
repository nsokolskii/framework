<?php

class m0001_initial{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nickname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            role TINYINT NOT NULL DEFAULT 0,
            confirmed TINYINT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE users";
        $db->pdo->exec($SQL);
    }
}