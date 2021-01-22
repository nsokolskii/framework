<?php

namespace app\repository;

use app\core\Application;

class MysqlRepository implements Repository{
    private $db;
    private $classname;
    private $table;
    private $tablesToClasses = [];

    public function __construct($args){
        
        foreach($args as $key => $value){
            $this->tablesToClasses[$key] = $value;
        }
        $this->db = Application::$app->db;
    }

    public function save($entry){
        $tableName = $entry->classname;
        $entryClassname = $this->tablesToClasses[$entry->classname];
        $attributes = $entryClassname::$attributes;
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $this->db->prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES(".implode(',', $params).")");
        foreach($attributes as $attribute){
            $statement->bindValue(":$attribute", $entry->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function setTable(string $tableName){
        $this->classname = $this->tablesToClasses[$tableName];
        $this->table = $tableName;
    }

    public function getTable(){
        return $this->table;
    }

    public function selectWhere($where, $filters = []){
        $data = [];
        $tableName = $this->table;
        $attributesWhat = $this->classname::$attributes;
        $attributesWhat[] = $this->classname::$primaryKey;
        $attributesWhere = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributesWhere));
        $statement = $this->db->pdo->prepare("SELECT ".implode(',', $attributesWhat)." FROM $tableName ".($sql ? "WHERE $sql" : ""));
        foreach($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        while($currentElement = $statement->fetchObject($this->classname)){
            if($currentElement){
                $data[] = $currentElement;
            }
        }
        return $data;
    }

    public function findOne($where){
        $selection = $this->selectWhere($where);
        return empty($selection) ? false : $selection[0];
    }

    public function removeOne($where){
        $tableName = $this->table;
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = $this->db->pdo->prepare("DELETE FROM $tableName WHERE $sql");
        foreach($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return true;
    }

    public function alterOne($where, $what){
        $tableName = $this->table;
        $attributesSet = array_keys($what);
        $attributesWhere = array_keys($where);
        $sqlSet = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributesSet));
        $sqlWhere = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributesWhere));
        $statement = $this->db->pdo->prepare("UPDATE $tableName SET $sqlSet WHERE $sqlWhere");
        foreach($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        foreach($what as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return true;
    }

    public function selectAll(){
        return $this->selectWhere([]);
    }
}