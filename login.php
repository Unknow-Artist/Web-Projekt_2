<?php 
session_start();

if(!empty($_POST['submit']) && !empty($_POST["email"]) && !empty($_POST["password"])) {
	require_once('db_inc.php');
	require_once('connect.php');

    $email = $_POST['email'];
    $passwort = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $statement = $db -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();
        
    //Überprüfung des Passworts
    if (password_verify($passwort, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    }
	else {
        $errorMessage = "Username oder Passwort war ungültig<br>";
    }
}
include_once('account.html');
?>