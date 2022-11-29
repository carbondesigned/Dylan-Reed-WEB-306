<?php

namespace App\Models;

use App\Lib\Model;
use App\Exceptions\ClassException;
use App\Exceptions\MailException;
use App\Lib\Logger;
use App\Lib\Mail;

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

    public function __construct(string $username, string $password, string $email)
    {
        $this->username = $username;
        $this->password = password_hash($password ?? "", PASSWORD_BCRYPT, ['cost' => 10]);
        $this->email = $email;
        $this->verify = $this->randStr();
    }

    public static function auth(string $email, string $password): bool | User {
        try {
            if (password_verify($password, $user->get('password'))) {
                return $user;
            }
        } catch (ClassException $e) {}
        return false;
    }

    private function randStr(): string {
        return substr(md5(rand()), 0, 16);
    }

    public function mailUser(): bool {
        $verifyString = urlencode($this->verify);
        $email = urlencode($this->email);
        $url = CONFIG_URL;
        $mail_body = <<<_MAIL_

    Hi $this->username, \n\n
    
    Please click on the following like to verify your new account: 
    <a href="{$url}/verify.php?email=$email&verify=$verifyString">Click here</a>
_MAIL_;

        try {
            return Mail::sendMail($this->email, $this->username, 'Verify your account', $mail_body);
        } catch (MailException $e) {
            Logger::getLogger()->critical("could not send mail: ", ['exception' => $e]);
            return false;
        }
    }
}