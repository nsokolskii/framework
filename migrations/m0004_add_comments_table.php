<?php

class m0004_add_comments_table{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            post INT(10) NOT NULL,
            author INT(10) NOT NULL,
            comment VARCHAR(512) NOT NULL,
            upvotes INT(10) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE comments";
        $db->pdo->exec($SQL);
    }
}