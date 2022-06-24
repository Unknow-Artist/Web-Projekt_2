<?php 
session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$db = getDb();
$message_id = $_GET["id"];

$statement = $db -> prepare("DELETE FROM message WHERE id = :message_id;");
$statement -> execute([':message_id' => $message_id]);

$db = null;
?>