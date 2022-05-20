<?php

require_once('db_inc.php');
require_once('connect.php');

function checkLogin($userGroup){
	if(isset($_SESSION['logedIn']) && isset($_SESSION['validTo']) && isset($_SESSION['userGroup'])){
		if($_SESSION['validTo'] > time() && in_array('autor', $_SESSION['userGroup'][0])){
			return;
		}
		else{
			session_unset();
			header('Location: http://localhost/Web-Projekt_2/php/index.php');
			exit;
		}
	}
	
	header('Location: http://localhost/Web-Projekt_2/php/index.php');
	exit;
}

function isUserLogedIn(){
	if(isset($_SESSION['logedIn']) && isset($_SESSION['validTo']) && isset($_SESSION['userGroup'])){
		if($_SESSION['validTo'] > time()){
			return true;
		}
		else{
			session_unset();
			return false;
		}
	}
	return false;
}

function logInUser($username, $password){

	global $db;
	$query = "SELECT * FROM user  WHERE username = :username AND password = :password LIMIT 1;" ;
		
		try{
			$prepStat = $db -> prepare($query);
			$prepStat -> bindParam(':username', $username);
			$prepStat -> bindParam(':password', $password);
			$prepStat -> execute();
		} catch (PDOException $e) {
			echo '<p>Verbindung fehlgeschlagen!</p>';
			if(ini_get('display_errors')){
				echo '<p>' . $e -> getMessage();
			}
			exit;
		}
/*
		$result = $prepStat -> fetchAll();
		if($result[0]['username'] == $username && $result[0]['password'] == $password){
			$_SESSION['logedIn'] = true;
			$_SESSION['validTo'] = time() + 60*60*24*7*365;
			$_SESSION['userGroup'][] = ['autor'];
			$_SESSION['lang'] = $result[0]['language'];
			$_SESSION['verfasser-ID'] = $result[0]['id'];
			$_SESSION['username'] = $result[0]['name'];
			return true;
		}
		else{
			return false;
		}
		*/

}

?>