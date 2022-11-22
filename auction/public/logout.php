<?php
use App\Exceptions\ClassException;
use App\Lib\Logger;
use App\Models\User;
// (A) ADD CODE TO REQUIRE THE BOOTSTRAP FILE BELOW
require_once __DIR__ . "/../app/bootstrap.php";

//Run the session logout method to logout the current user
// (B) USE THE CORRECT SESSION CLASS METHOD TO LOGOUT THE USER
Session::logout();


// (C) REDIRECT THE USER TO THE index.php PAGE
header("Location: index.php");

die();