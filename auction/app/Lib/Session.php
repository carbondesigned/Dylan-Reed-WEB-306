<?php

namespace App\Lib;
use App\Models\User;
use PDO;
use PDOException;
use SessionHandlerInterface;

class Session implements SessionHandlerInterface
{
    static $dbConnection;
    private bool | User $user = false;

    /**
     * @return void
     */
    public function __contruct(): void {
        session_start();
        if(isset($_SESSION['user'])) {
            $this->user = $_SESSION('user');
        }
        session_set_save_handler($this, true);
    }

    public function __destruct()
    {
        session_write_close();
    }

    /**
     * @return bool|User
     */
    public function isLoggedIn(): bool | User {
        return $this->user;
    }

    /**
     * @return User
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function login(User $user): bool {
        $this->user = $user;
        $_SESSION['user'] = $user;
        return true;
    }

    /**
     * @return bool
     */
    public function logout(): bool {
        $this->user = null;
        unset($_SESSION['user']);
        session_destroy();
        return true;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        $dbConnection = null;
        return true;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function destroy(string $id): bool
    {
        try {
            $sql = "DELETE FROM sessions WHERE id = :id";
            $stmt = self::$dbConnection->prepare($sql);
            return $stmt->exectue(compact('id'));
        } catch (PDOException $e) {
            Logger::getLogger()->critical('could not exectue query: ' . $e->getMessage());
            return false;
            die();
        }
    }

    /**
     * @param int $max_lifetime
     * @return int|bool
     */
    public function gc(int $max_lifetime): int | false
    {
        try {
            $sql = "DELETE FROM `sessions` WHERE DATE_ADD(last_accessed, INTERVAL $max_lifetime) < NOW()";
            $stmt = self::$dbConnection->prepare($sql);
            $result = $stmt->execute();
            return $result ? $stmt->rowCount() : false;
        } catch (PDOException $e) {
            Logger::getLogger()->critical('could not exectue query: ' . $e->getMessage());
            return false;
            die();
        }
    }

    /**
     * @param string $path
     * @param string $name
     * @return bool
     */
    public function open(string $path, string $name): bool
    {
        try {
            self::$dbConnection = new PDO('mysql:host=localhost;dbname=phpauth', 'root', '');
            self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return true;
    } catch (PDOException $e) {
            Logger::getLogger()->critical('could not connect to database', ['exception' => $e]);
            die();
        return false;
    }
    if (isset($dbConnection)) {
        return true;
    } else {
        return false;
    }
    }

    /**
     * @param string $id
     * @return string|false
     */
    public function read(string $id): string | false
    {
        try {
            $sql = 'SELECT data FROM sessions WHERE id = :id';
            $stmt = self::$dbConnection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['data'];
            } else {
                return '';
            }
        } catch (PDOException $e) {
            Logger::getLogger()->critical('could not read session data', ['exception' => $e]);
            die();
            return false;
        }
    }

    /**
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write(string $id, string $data): bool
    {
        try {
            $sql = "REPLACE INTO `sessions` (id, data) VALUES (:id, :data)";
            $stmt = self::$dbConnection->prepare($sql);
            return $stmt->execute(compact('id', 'data'));
        } catch (PDOException $e) {
            Logger::getLogger()->critical('could not write session data', ['exception' => $e]);
            die();
            return false;
        }
    }
}