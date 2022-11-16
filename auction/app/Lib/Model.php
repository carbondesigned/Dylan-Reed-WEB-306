<?php

namespace App\Lib;

use App\Exceptions\ClassException;
use PDO;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class Model
{

    use Helper;

    /**
     * @param $cond
     * @param string|null $groupBy
     * @param string|null $orderBy
     * @param $limit
     * @return array
     */
    public static function find($cond = null, string $groupBy = null, string $orderBy = null, $limit = null): array {
       $db = Database::getConnection();
       $sql = "SELECT * FROM `" . static::$table_name . "`";
       if (is_array($cond)) {
           $sql .= " WHERE ";
           $bindings = [];
           foreach ($cond as $key => $value) {
               $bindings[] = "`$key` = :$key";
           }
           $sql .= implode(" AND ", $bindings);
       } else if ($cond != null) {
              $sql .= " WHERE $cond";
       }

       if (isset($groupBy)) {
           $sql .= " GROUP BY $groupBy";
       }

       if (isset($orderBy)) {
           $sql .= " ORDER BY $orderBy";
       }

         if (isset($limit)) {
              $sql .= " LIMIT $limit";
         }

        return $db->fetch($sql, get_called_class(), $cond);
    }

    /**
     * @param $cond
     * @param string|null $groupBy
     * @return mixed|null
     */
    public static function findFirst($cond = null, string $groupBy = null) {
       $objs = static::find($cond, $groupBy, null, 1);
       if (empty($objs)) throw new ClassException("Model not found");
       return array_shift($objs);
    }

    /**
     * @param string|null $groupBy
     * @param string|null $orderBy
     * @return array
     */
    public static function all(string $groupBy = null, string $orderBy = null): array {
       $objs = static::find(null, $groupBy, $orderBy);
         if (empty($objs)) throw new ClassException("Model not found");
         return $objs;
    }
}