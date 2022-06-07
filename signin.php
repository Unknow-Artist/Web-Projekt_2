<?php
session_start();
if (isset($_SESSION["user_id"]) && isset($_SESSION["username"]) && isset($_SESSION["conversation_id"])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/php/functions.php';

if (isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user = login($email, $password)) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["conversation_id"] = getConversationId($user['id']);

        header("Location: index.php");
        exit;
    }
}

if(!empty($_POST["google_id"]) && !empty($_POST["google_name"])) {
    $google_id = $_POST['google_id'];
    $google_name = $_POST['google_name'];

    if ($user = google_login($google_id)) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["conversation_id"] = getConversationId($user['id']);

        header("Location: index.php");
        exit;
    }
}

include_once('html/signin.html');
?>