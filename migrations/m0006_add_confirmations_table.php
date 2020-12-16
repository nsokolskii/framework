<?php

class m0006_add_confirmations_table{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE confirmations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(256) NOT NULL,
            confirmationCode VARCHAR(512) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE confirmations";
        $db->pdo->exec($SQL);
    }
}