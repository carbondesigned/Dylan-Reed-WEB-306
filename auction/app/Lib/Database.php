<?php

namespace App\Lib;

use PDO;
use PDOException;
use ReflectionClass;
use ReflectionException;

/**
 *
 */
class Database
{
    private static $databaseObj;
    private  $connection;

    public static function getConnection() {
        if (!self::$databaseObj) {
            self::$databaseObj = new self();
        }
        return self::$databaseObj;
    }

    private function __construct(){
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            Logger::getLogger()->critical("Could not create DB Connection", ['exception' => $err]);
        }
    }
    public function __destruct(){
        $this->connection = null;
    }

    public function sqlQuery(string $sql, $bindVal = null, $retStmt = false) {
        try {
            $stmt = $this->connection->prepare($sql);
            if (is_array($bindVal)) {
                $result = $stmt->execute($bindVal);
            } else {
                $result = $stmt->execute();
            }
            if ($retStmt) {
                return $stmt;
            } else {
                return $result;
            }
        } catch (PDOException $err) {
            Logger::getLogger()->critical("Could not execute SQL Query", ['exception' => $err]);
        }
    }
    public function fetch(string $sql, string $class, $bindVal = null) {
        $stmt = $this->sqlQuery($sql, $bindVal, true);
        if ($stmt->rowCount() == 0) {
            return [];
        }
        try {
            $reflect = new ReflectionClass($class);
            if ($reflect->getConstructor() == null) {
                $ctor_args = [];
            } else {
                $num = count($reflect->getConstructor()->getParameters());
                $ctor_args = array_fill(0, $num, null);
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class, $ctor_args);
        } catch (ReflectionException $err) {
            Logger::getLogger()->critical("Could not fetch data", ['exception' => $err]);
        }
    }
    public function lastInsertId(): string {
        $id = $this->connection->lastInsertId();
        return $id;
    }
    public function rowCount(string $sql, $bindVal = null): int {
        $stmt = $this->sqlQuery($sql, $bindVal, true);
        return $stmt->rowCount();
    }
}