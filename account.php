<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
    // Datenbank verbinden
    require('php/db_inc.php');
    require('php/connect.php');
    
    // Daten aus Formular holen
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // SQL-Statement erstellen
    $statement = $db -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();
        
    // Überprüfung des Passworts
    if ($user !== false && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}

if(!empty($_POST['register'])) {
    $username = htmlentities($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = htmlentities($_POST['email']);

    // Datenbank-Verbindung aufbauen, Datenbank wählen
    require('db_inc.php');
    require('connect.php');

    // Datensatz speichern
    $statement = $db -> prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();
    $_SESSION["user_id"] = $db -> lastInsertId();
    $_SESSION["username"] = $username;

    // Datenbank-Verbindung schließen
    $db = null;
}
include_once('html/account.html');
?>