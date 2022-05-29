<?php
session_start();

require_once __DIR__ . '/php/functions.php';

if (isset($_COOKIE["user_id"]) && isset($_COOKIE["username"])) {
    header("Location: index.php");
}

if (isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (login($email, $password)) {
        $user = login($email, $password);
        setcookie("user_id", $user["id"], time() + (86400 * 30));
        setcookie("username", $user["username"], time() + (86400 * 30));
        setcookie("selected_conversation", 1, time() + (86400 * 30));
        header("Location: index.php");
    }
}

if(!empty($_POST["google_id"]) && !empty($_POST["google_name"]) && !empty($_POST["google_email"])) {
    $google_id = $_POST['google_id'];
    $google_name = $_POST['google_name'];
    $google_email = $_POST['google_email'];

    if (google_login($google_id)) {
        $user = google_login($google_id);
        setcookie("user_id", $user["id"], time() + (86400 * 30));
        setcookie("username", $user["username"], time() + (86400 * 30));
        setcookie("selected_conversation", 1, time() + (86400 * 30));
        header("Location: index.php");
    }
}

include_once('html/signin.html');
?>