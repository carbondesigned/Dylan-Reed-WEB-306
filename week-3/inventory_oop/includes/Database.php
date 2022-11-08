<?php

class Database
{
    public $connection;
    function __construct()
    {
        $this->dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->connection = $this->dbc;
    }
    // The sqlQuery method is used to Create, Update and Delete records from the database. 
    function sqlQuery($sql)
    {
        $dbc = $this->connection;
        $result = $dbc->query($sql);
        return $result;
    }
    // The fetchArray method is used to Retrieve a list of records from the database. 
    function fetchArray($sql)
    {
        $result = $this->sqlQuery($sql);
        $rows = $result->rowCount();
        if ($rows == 0) {
            return false;
        } else {
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
    // The fetchRecord method is used to Retrieve a single record from the database. 
    function fetchRecord($sql)
    {
        $result = $this->sqlQuery($sql);
        $rows = $result->rowCount();
        if ($rows == 0) {
            return false;
        } else {
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }
}

$dbc = new Database();
