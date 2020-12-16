<?php

class m0007_add_restore_table{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE restore (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(256) NOT NULL,
            hash VARCHAR(512) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE restore";
        $db->pdo->exec($SQL);
    }
}