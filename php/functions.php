<?php
function getDb() {
	require __DIR__ . '/db_inc.php';
	require __DIR__ . '/connect.php';
	return $db;
}

function login($email, $password) {
	$statement = getDb() -> prepare("SELECT id, username, password FROM user WHERE email = :email");
    $statement -> execute([':email' => $email]);
    $user = $statement -> fetch();

	return ($user !== false && password_verify($password, $user['password'])) ? $user : false;
}

function google_login($google_id) {
	$statement = getDb() -> prepare("SELECT id, username FROM user WHERE google_id = :google_id");
	$statement -> execute([':google_id' => $google_id]);
	$user = $statement -> fetch();

	return $user !== false ? $user : false;
}

function register($username, $password, $email) {
	$db = getDb();

	$statement = $db -> prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
    $statement -> execute([':username' => $username, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT)]);

	return $statement -> rowCount() == 1 ? true : false;
}

function getUserById($id) {
	$statement = getDb() -> prepare("SELECT username FROM user WHERE id = :id");
	$statement -> execute([':id' => $id]);
	$user = $statement -> fetch();
	
	return $user !== false ? $user : false;
}

function getConversationId($user_id) {
	$statement = getDb() -> prepare("SELECT conversation_id FROM group_member WHERE user_id = :user_id");
	$statement -> execute([':user_id' => $user_id]);
	$conversation_id = $statement -> fetch();
	
	return $conversation_id !== false ? $conversation_id : false;
}
?>