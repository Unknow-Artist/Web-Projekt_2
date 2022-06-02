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

include_once('html/signup.html');
?>