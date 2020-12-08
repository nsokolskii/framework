<?php

class m0003_add_shots_table{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE shots (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description VARCHAR(1024) NOT NULL,
            author INT(10) NOT NULL,
            image VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE shots";
        $db->pdo->exec($SQL);
    }
}