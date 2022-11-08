<?php

namespace App\Models;

class User
{
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
        $this->password = $password;
        $this->email = $email;
        $this->verify = $verify;
    }

}