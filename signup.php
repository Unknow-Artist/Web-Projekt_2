<?php
session_start();

require_once __DIR__ . '/php/functions.php';

if(isset($_POST['register']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['username'])) {
    $email = htmlentities($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = htmlentities($_POST['username']);

    if(register($username, $password, $email)) {
        header('Location: signin.php');
    }
}

include_once('html/signup.html');
?>