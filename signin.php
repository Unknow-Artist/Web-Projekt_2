<?php
session_start();

require_once 'php/functions.php';

if (isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (login($email, $password)) {
        $user = login($email, $password);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    }
}

if(!empty($_POST["google_id"]) && !empty($_POST["google_name"]) && !empty($_POST["google_email"])) {
    $google_id = $_POST['google_id'];
    $google_name = $_POST['google_name'];
    $google_email = $_POST['google_email'];

    if (google_login($google_id)) {
        $user = google_login($google_id);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    }
}

include_once('html/signin.html');
?>