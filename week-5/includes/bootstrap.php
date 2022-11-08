<?php
require_once("config.php");

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$session = new Session();
$dbc = new Database();
