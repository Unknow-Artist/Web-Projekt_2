<?php
function getDb() {
	require 'php/db_inc.php';
	require 'php/connect.php';
	return $db;
}

function login($email, $password) {
	$statement = getDb() -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();

	if ($user !== false && password_verify($password, $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		return true;
	} else {
		return false;
	}
}

function register($email, $password, $username) {
	$statement = getDb() -> prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();

	if ($statement -> rowCount() == 1) {
		$_SESSION['user_id'] = $db -> lastInsertId();
		$_SESSION['username'] = $username;
		return true;
	} else {
		return false;
	}
}

function isUserLoggedIn() {
	return (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) ? false : true;
}

function getUserData($id) {
	$statement = getDb() -> prepare("SELECT id, username, email FROM user WHERE id = :id");
	$statement -> bindParam(':id', $id);
	$statement -> execute();
	return $statement -> fetch();
}

function parseTemplate($file, $searchArray) {
	$inhalt = file($file);
    for ($i = 0; $i < count($searchArray); $i++) {
        $inhalt = str_replace($searchArray[$i][0], $searchArray[$i][1], $inhalt);
    }
	return $inhalt;
}

function getMessages() {
	require('php/db_inc.php');
	require('php/connect.php');

	$inhalt = "";
	$messages = $db -> query("SELECT id, user_id, created, text FROM message ORDER BY id DESC");

	foreach ($messages as $message) {
		$date = date_create($message["created"]);
		$today = date_create(date("Y-m-d"));
		$diff = date_diff($date, $today);
		$diff = $diff -> format("%a");

		if ($diff == 0) {
			$created = "Heute um " . date("H:i", strtotime($message["created"]));
		}
		else {
			$created = date("d.m.Y", strtotime($message["created"]));
		}

		if ($message["user_id"] == $_SESSION["user_id"]) {
			$alignment = 'align-self-end';
			$color = 'text-bg-primary';
		}
		else {
			$alignment = '';
			$color = 'text-bg-secondary';
		}

		$userData = getUserData($message["user_id"]);
		$inhalt .= <<<MESSAGE
		<div class="badge rounded-pill text-start px-4 py-2 message $alignment $color">
			<div class="d-flex flex-row justify-content-between">
				<strong>$userData[username]</strong>
				<span>$created</span>
			</div>
			<p class="m-0 fw-normal">$message[text]</p>
		</div>
		MESSAGE;
	}
	return $inhalt;
}
?>