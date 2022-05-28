<?php
function getDb() {
	require __DIR__ . '/db_inc.php';
	require __DIR__ . '/connect.php';
	return $db;
}

function login($email, $password) {
	$statement = getDb() -> prepare("SELECT * FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();

	return ($user !== false && password_verify($password, $user['password'])) ? $user : false;
}

function google_login($google_id) {
	$statement = getDb() -> prepare("SELECT * FROM user WHERE google_id = :google_id");
	$statement -> bindParam(':google_id', $google_id);
	$statement -> execute();
	$user = $statement -> fetch();

	return $user !== false ? $user : false;

	if ($user !== false) {
		return $user;
	}
	else {
		return false;
	}
}

function register($username, $password, $email) {
	$db = getDb();
	
	if (empty($google_id)) {
		$statement = getDb() -> prepare("INSERT INTO user (username, email, password, type) VALUES (:username, :email, :password, :type)");
		$statement -> bindParam(':type', 'standard-user');
	}
	else {
		$statement = getDb() -> prepare("INSERT INTO user (google_id, username, email, password, type) VALUES (:username, :email, :password, :google_id, :type)");
		$statement -> bindParam(':type', 'google-user');
	}
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();

	$last_id = getDb() -> lastInsertId();
	$table = $db -> query("SELECT * FROM user WHERE id = $last_id");
	$user = $table -> fetch();

	return $statement -> rowCount() == 1 ? $user : false;
}

function isUserLoggedIn() {
	return (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) ? false : true;
}

function getUserData($id) {
	$statement = getDb() -> prepare("SELECT * FROM user WHERE id = :id");
	$statement -> bindParam(':id', $id);
	$statement -> execute();
	$user = $statement -> fetch();
	return $user;
}

function parseTemplate($file, $searchArray) {
	$inhalt = file($file);
    for ($i = 0; $i < count($searchArray); $i++) {
        $inhalt = str_replace($searchArray[$i][0], $searchArray[$i][1], $inhalt);
    }
	return $inhalt;
}

function getMessages($conversation_id) {
	$inhalt = "";
	$db = getDb();

	$messages = $db -> prepare("SELECT * FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC");
	$messages -> bindParam(':conversation_id', $conversation_id);
	$messages -> execute();

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

		if ($message["sender_id"] == $_SESSION["user_id"]) {
			$alignment = 'align-self-end';
			$color = 'text-bg-primary';
			$border = 'border-radius: 15px 0 15px 15px;';
		}
		else {
			$alignment = '';
			$color = 'text-bg-secondary';
			$border = 'border-radius: 0 15px 15px 15px;';
		}

		$userData = getUserData($message["sender_id"]);
		$inhalt .= <<<MESSAGE
		<div class="message px-3 py-2 $alignment $color" style="$border">
			<div class="d-flex flex-row justify-content-between">
				<strong>$userData[username]</strong>
				<span>$created</span>
			</div>
			<p class="m-0 fw-normal text-wrap">$message[text]</p>
		</div>
		MESSAGE;
	}
	return $inhalt;
}

function getContacts() {
	$db = getDb();
	$inhalt = "";

	$conversations = $db -> prepare("SELECT * FROM conversation INNER JOIN group_member ON conversation.id = group_member.conversation_id WHERE group_member.user_id = :user_id");
	$conversations -> bindParam(':user_id', $_SESSION["user_id"]);
	$conversations -> execute();

	foreach($conversations as $conversation) {
		$messages = $db -> prepare("SELECT sender_id, text FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC LIMIT 1");
		$messages -> bindParam(':conversation_id', $conversation["conversation_id"]);
		$messages -> execute();
		$message = $messages -> fetch();

		$sender = getUserData($message["sender_id"]);
		$text = $sender["username"] . ": " . $message["text"];

		if (strlen($message["text"]) > 32) {
			$text = substr($text, 0, 32) . "...";
		}

		$inhalt .= <<<CONTACT
		<div class="list-group-item list-group-item-action py-3">
			<strong>$conversation[name]</strong>
			<p class="m-0">$text</p>
		</div>
		CONTACT;
	}

	return $inhalt;
}
?>