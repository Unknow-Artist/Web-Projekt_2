<?php 
session_start();

if(isset($_POST["login"]) && !empty($_POST["loginPassword"]) && !empty($_POST["loginEmail"])) {
    $email = $_POST['loginEmail'];
    $password = password_hash($_POST['loginPassword'], PASSWORD_DEFAULT);

    if (login($email, $password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    }
}
include_once('html/signin.html');
?>