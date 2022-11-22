<?php

namespace App\Models;

use App\Lib\Model;
use App\Exceptions\ClassException;

class User extends Model
{
    public static $errorArray = array(
        'password' => 'Passwords do not match!',
        'taken' => 'Username is already taken!',
        'invalid' => 'Invalid username or password!',
        'failedlogin' => 'Failed to login!',
    );

    protected static string $table_name = 'users';
    protected int $id = 0;
    protected string $username;
    protected string $password;
    protected string $email;
    protected string $verify;
    protected int $active = 0;

    public function __construct(string $username, string $password, string $email, string $verify)
    {
        $this->username = $username;
        $this->password = password_hash($password ?? "", PASSWORD_BCRYPT, ['cost' => 10]);
        $this->email = $email;
        $this->verify = $verify;
    }

    public static function auth(string $email, string $password): bool | User {
        try {
            if (password_verify($password, $user->get('password'))) {
                return $user;
            }
        } catch (ClassException $e) {}
        return false;
    }
}