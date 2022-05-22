<?php
require_once('php/functions.php');
require_once('php/db_inc.php');
require_once('php/connect.php');

session_start();

if (!isUserLoggedIn()) header("Location: signin.php");
$userData = getUserData($_SESSION["user_id"]);

if (isset($_POST["sendMessage"]) && !empty($_POST["message"])) {

    // message einlesen
    $message = htmlentities($_POST["message"]);

    // user_id aus session holen
    $user_id = $_SESSION["user_id"];

    // sql-statement erstellen
    $statement = $db -> prepare("INSERT INTO message (user_id, text) VALUES (:user_id, :text);");
    $statement -> bindParam(':user_id', $user_id);
    $statement -> bindParam(':text', $message);
    $statement -> execute();
}

$searchArray = array(
    array('### Nachrichten ###', getMessages())
);

foreach (parseTemplate('html/index.html', $searchArray) as $zeile) {
    echo $zeile;
}
