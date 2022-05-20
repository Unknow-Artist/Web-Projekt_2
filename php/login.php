<?php 
session_start();

if(!empty($_POST['senden']) && !empty($_POST["email"]) && !empty($_POST["password"])) {
	require_once('db_inc.php');
	require_once('connect.php');

    $email = $_POST['email'];
    $passwort = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $statement = $db -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();


	echo $user['password'];
        
    //Überprüfung des Passworts
    if (password_verify($passwort, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    }
	else {
        $errorMessage = "Username oder Passwort war ungültig<br>";
    }
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title> 
</head> 
<body>
	<form action="login.php" method="post">
		<label>E-Mail:</label><br>
		<input type="text" size="40" maxlength="250" name="email"><br><br>
		
		<label>Dein Passwort:</label><br>
		<input type="password" size="40"  maxlength="250" name="password"><br>
		
		<input type="submit" name="senden" value="Senden">
	</form> 
</body>
</html>