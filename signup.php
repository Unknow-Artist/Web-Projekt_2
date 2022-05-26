<?php 
if(isset($_POST['register']) && !empty($_POST['registerPassword']) && !empty($_POST['registerEmail']) && !empty($_POST['registerUsername'])) {
    $email = htmlentities($_POST['registerEmail']);
    $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT);
    $username = htmlentities($_POST['registerUsername']);


    // Datensatz speichern
    

    $_SESSION["user_id"] = $db -> lastInsertId();
    $_SESSION["username"] = $username;

    header('Location: index.php');
}
include_once('html/signup.html');
?>