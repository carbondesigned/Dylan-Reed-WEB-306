<?php
require_once('config.php');
/* It takes a SQL query and an optional array of values to bind to the query, and returns a
PDOStatement object */
class Database
{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    }
    public function __destruct()
    {
        // Close the database connection
        $this->connection = null;
    }
    /**
     * It takes a SQL query and an optional array of values to bind to the query, and returns a
     * PDOStatement object
     * 
     * @param sql The SQL query you want to run.
     * @param bindVal This is an array of values that will be bound to the query.
     * 
     * @return The statement object.
     */
    public function sqlQuery($sql, $bindVal = null)
    {
        $statement = $this->connection->prepare($sql);
        if (is_array($bindVal)) {
            $statement->execute($bindVal);
        } else {
            $statement->execute();
        }
        return $statement;
    }
    /**
     * It takes a SQL query and an optional array of bind values, and returns an array of associative
     * arrays
     * 
     * @param sql The SQL query to be executed.
     * @param bindVal This is an array of values to bind to the query.
     * 
     * @return An array of associative arrays.
     */
    public function fetchArray($sql, $bindVal = null)
    {
        $res = $this->sqlQuery($sql, $bindVal);
        if ($res->rowCount() == 0) {
            return false;
        } else {
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
