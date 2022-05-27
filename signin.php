<?php
session_start();

if (isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (login($email, $password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    }
}

include_once('html/signin.html');
?>