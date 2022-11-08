<?php

class Session
{
    private $user;

    /**
     * The function starts a session and if the session variable 'user' is set, it sets the class
     * variable 'user' to the value of the session variable 'user'
     */
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
    }
    /**
     * If the user is logged in, return true, otherwise return false
     * 
     * @return A boolean value.
     */
    public function isLoggedIn()
    {
        if ($this->user) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * This function returns the user
     * 
     * @return The user object.
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * It takes a user object and sets it to the user property of the class and also sets it to the
     * user session variable.
     * 
     * @param userObj The user object that you want to log in.
     */
    public function login($userObj)
    {
        $this->user = $userObj;
        $_SESSION['user'] = $userObj;
    }
    /**
     * It destroys the session
     */
    public function logout()
    {
        $this->user = null;
        session_destroy();
    }
}
