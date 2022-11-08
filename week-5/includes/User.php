<?php
class User
{
    private $id;
    private $username;
    private $password;

    /**
     * It takes a username and password, checks the database for a matching username, and if it finds
     * one, it checks the password against the hashed password in the database. If the password
     * matches, it returns a new User object
     * 
     * @param username The username of the user you want to authenticate.
     * @param password The password to verify
     * 
     * @return An object of the User class.
     */
    public static function auth($username, $password)
    {
        global $dbc;
        $sql = "SELECT * FROM `logins` where username = :username LIMIT 1";
        $bindVal = ['username' => $username];
        $userRecord = $dbc->fetchArray($sql, $bindVal);

        if ($userRecord) {
            $userRecord = array_shift($userRecord);
            if (password_verify($password, $userRecord['password'])) {
                return new User($userRecord['id'], $userRecord['username'], $userRecord['password']);
            }

            return false;
        }
    }
    /**
     * The constructor function is a special function that is called when an object is created
     * 
     * @param id The id of the user.
     * @param username The username of the user.
     * @param password The password for the user.
     */
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * This function sets the id of the object
     * 
     * @param id The id of the user.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * It returns the id of the object.
     * 
     * @return The id of the user.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * This function sets the username
     * 
     * @param username The username of the user you want to get the information for.
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * This function returns the username of the user
     * 
     * @return The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * This function sets the password of the user
     * 
     * @param password The password to use for the connection.
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * This function returns the value of the password property
     * 
     * @return The password.
     */
    public function getPassword()
    {
        return $this->password;
    }
}
