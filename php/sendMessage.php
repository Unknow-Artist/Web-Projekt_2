<?php
if(!(isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')){
    header('Location: ../index.php');
    exit;
}

session_start();
require_once __DIR__ . '/functions.php';
header('Content-Type: application/json; charset=utf-8');

$user_id = $_SESSION["user_id"];
$conversation_id = $_SESSION["conversation_id"];
$message = htmlentities($_POST['message']);



$db = getDb();
$statement = $db -> prepare("INSERT INTO message (sender_id, text, conversation_id) VALUES (:sender_id, :text, :conversation_id);");
$statement -> execute([':sender_id' => $user_id, ':text' => $message, ':conversation_id' => $conversation_id]);

$db = null;
?>