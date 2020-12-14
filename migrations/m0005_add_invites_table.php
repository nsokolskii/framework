<?php

class m0005_add_invites_table{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE invites (
            id INT AUTO_INCREMENT PRIMARY KEY,
            invitationCode VARCHAR(10) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE invites";
        $db->pdo->exec($SQL);
    }
}