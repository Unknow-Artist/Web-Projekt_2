<?php
    require_once('loginCheck.php');

    $meldung = '';

    if(isUserLogedIn()){
        header('Location: admin/index.php?PHPSESSID=' . session_id());
        exit(0);
    }

    if(isset($_POST['Login'])){
		if(logInUser($_POST['userName'], $_POST['password'])){
			header('Location: admin/index.php?PHPSESSID=' . session_id());
		}
		else{
			$meldung = "Login falsch";
		}
	}

?>

<!DOCTYPE html>
<html lang="de-CH">
	<head>
		<meta charset="utf-8">
		<title>Musikalbenverwaltung</title>
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<header>
			<h1>Musikalbenverwaltung</h1>
		</header>
		<h2>Admin - Login</h2>
		<div class ="formAreas">
			<div class="formArea">
				<form action="login.php" method="post">
					<p><?php
					echo $meldung;
					?></p>
					<label for="userName">Benutzername: </label><Input type="text" name="userName" id="userName" required> <br>
					<label for="password">Passwort: </label><Input type="password" name="password" id="password" required> <br>
					<input type="submit" value="Login" name="Login">
				</form>
			</div>
		</div>
	</body>
</html>