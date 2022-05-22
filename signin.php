<?php 
session_start();

if(isset($_POST["login"]) && !empty($_POST["loginPassword"]) && !empty($_POST["loginEmail"])) {
    // Datenbank verbinden
    require('php/db_inc.php');
    require('php/connect.php');
    
    // Daten aus Formular holen
    $email = $_POST['loginEmail'];
    $password = password_hash($_POST['loginPassword'], PASSWORD_DEFAULT);
    
    // SQL-Statement erstellen
    $statement = $db -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();
        
    // Überprüfung des Passworts
    if ($user !== false && password_verify($_POST['loginPassword'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}

if(isset($_POST['register']) && !empty($_POST['registerPassword']) && !empty($_POST['registerEmail']) && !empty($_POST['registerUsername'])) {
    // Datenbank verbinden
    require('php/db_inc.php');
    require('php/connect.php');

    // Daten aus Formular holen
    $username = htmlentities($_POST['registerUsername']);
    $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT);
    $email = htmlentities($_POST['registerEmail']);

    // Datensatz speichern
    $statement = $db -> prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();

    $_SESSION["user_id"] = $db -> lastInsertId();
    $_SESSION["username"] = $username;

    header('Location: index.php');
}
include_once('html/account.html');
?>