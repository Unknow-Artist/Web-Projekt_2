<?php 
session_start();

if(!empty($_POST['login']) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    // Datenbank verbinden
    require('db_inc.php');
    require('connect.php');

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $statement = $db -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();
        
    // Überprüfung des Passworts
    if ($user !== false && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    }
	else {
        $errorMessage = "Username oder Passwort war ungültig<br>";
    }
}

if(!empty($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = htmlspecialchars($_POST['email']);

    // Datenbank-Verbindung aufbauen, Datenbank wählen
    require('db_inc.php');
    require('connect.php');

    // Datensatz speichern
    $statement = $db -> prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();
    $user_id = $db -> lastInsertId();
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;

    // Datenbank-Verbindung schließen
    $db = null;
}
include_once('html/account.html');
?>