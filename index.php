<?php
session_start();
require_once('php/functions.php');
if (!isUserLoggedIn()) header("Location: signin.php");

$userData = getUserData($_SESSION["user_id"]);
$conversation_id = 1;
$db = getDb();

if (isset($_POST["sendMessage"]) && !empty($_POST["message"])) {
    $message = htmlentities($_POST["message"]);
    $user_id = $userData["id"];

    $statement = $db -> prepare("INSERT INTO message (sender_id, text, conversation_id) VALUES (:sender_id, :text, :conversation_id);");
    $statement -> bindParam(':sender_id', $user_id);
    $statement -> bindParam(':text', $message);
    $statement -> bindParam(':conversation_id', $conversation_id);
    $statement -> execute();
}

$searchArray = array(
    array('### Nachrichten ###', getMessages($conversation_id)),
    array('### Kontakte ###', getContacts()),
);

foreach (parseTemplate('html/index.html', $searchArray) as $zeile) {
    echo $zeile;
}