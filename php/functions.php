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
?>