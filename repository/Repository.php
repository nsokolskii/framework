<?php

namespace app\repository;

interface Repository{
    public function save($dataEntry);
    public function findOne($where);
    public function removeOne($where);
    public function alterOne($where, $what);
    public function selectWhere($where, $filters, $interval);
    public function selectAll();
    public function setTable(string $tableName);
    public function getTable();
    public function search($where, $what);
}