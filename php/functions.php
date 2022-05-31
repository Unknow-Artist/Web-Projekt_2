<?php
function getDb() {
	require __DIR__ . '/db_inc.php';
	require __DIR__ . '/connect.php';
	return $db;
}

function login($email, $password) {
	$statement = getDb() -> prepare("SELECT password FROM user WHERE email = :email");
	$statement -> bindParam(':email', $email);
    $statement -> execute();
    $user = $statement -> fetch();

	return ($user !== false && password_verify($password, $user['password'])) ? $user : false;
}

function google_login($google_id) {
	$statement = getDb() -> prepare("SELECT id, username FROM user WHERE google_id = :google_id");
	$statement -> bindParam(':google_id', $google_id);
	$statement -> execute();
	$user = $statement -> fetch();

	return $user !== false ? $user : false;
}

function register($username, $password, $email) {
	$db = getDb();
	
	if (empty($google_id)) {
		$statement = $db -> prepare("INSERT INTO user (username, email, password, type) VALUES (:username, :email, :password, :type)");
		$statement -> bindParam(':type', 'standard-user');
	}
	else {
		$statement = $db -> prepare("INSERT INTO user (google_id, username, email, password, type) VALUES (:username, :email, :password, :google_id, :type)");
		$statement -> bindParam(':type', 'google-user');
	}
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);
    $statement -> execute();

	$last_id = $db -> lastInsertId();
	$table = $db -> query("SELECT * FROM user WHERE id = $last_id");
	$user = $table -> fetch();

	return $statement -> rowCount() == 1 ? $user : false;
}

function getUserById($id) {
	$statement = getDb() -> prepare("SELECT username FROM user WHERE id = :id");
	$statement -> execute([':id' => $id]);
	$user = $statement -> fetch();
	
	return $user !== false ? $user : false;
}
?>