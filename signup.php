<?php
session_start();

require_once __DIR__ . '/php/functions.php';

if(isset($_POST['register']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['username'])) {
    $email = htmlentities($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = htmlentities($_POST['username']);

    if(register($username, $password, $email)) {
        $_SESSION['user_id'] = getDb() -> lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['conversation_id'] = getConversationId($_SESSION['user_id']);
        header('Location: index.php');
    }
}

if(!empty($_POST['google_id']) && !empty($_POST['google_name']) && !empty($_POST['google_email'])) {
    $google_id = htmlentities($_POST['google_id']);
    $username = htmlentities($_POST['google_name']);
    $email = htmlentities($_POST['google_email']);

    if(google_register($google_id, $username, $email)) {
        $_SESSION['user_id'] = getDb() -> lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['conversation_id'] = getConversationId($_SESSION['user_id']);
        header('Location: index.php');
    }
}

include_once('html/signup.html');
?>