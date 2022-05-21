<?php
// datenbankverbindung aufbauen und datenbank auswählen
require_once('php/db_inc.php');
require_once('php/connect.php');

if (isset($_POST["submit"])) {
    // message einlesen
    $message = htmlentities($_POST["message"]);

    // user_id aus session holen
    $user_id = $_SESSION["user_id"];

    // sql-statement erstellen
    $statement = $db -> prepare("INSERT INTO chat (user_id, message) VALUES (:user_id, :message)");
    $statement -> bindParam(':user_id', $user_id);
    $statement -> bindParam(':message', $message);
    $statement -> execute();
}
?>