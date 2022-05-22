<?php
function isUserLoggedIn() {
	return (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) ? false : true;
}

function getUserData($id) {
	require('php/db_inc.php');
	require('php/connect.php');
	$statement = $db -> prepare("SELECT id, username, email FROM user WHERE id = :id");
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
		} else {
			$created = date("d.m.Y", strtotime($message["created"]));
		}

		if ($message["user_id"] == $_SESSION["user_id"]) {
			$alignment = 'align-self-end';
		}
		else {
			$alignment = none;
		}

		$userData = getUserData($message["user_id"]);
		$inhalt .= <<<MESSAGE
		<div class="badge rounded-pill text-bg-primary text-start px-4 py-2 message $alignment">
		<div class="d-flex flex-row justify-content-between">
			<strong>$userData[username]</strong>
			<span>$created</span>
		</div>
			<p class="m-0 mt-1 fw-normal">$message[text]</p>
		</div>
		MESSAGE;
	}
	return $inhalt;
}
?>