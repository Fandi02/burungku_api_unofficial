<?php

class DB{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'burung';

    public function connect(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}