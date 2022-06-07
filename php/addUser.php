<?php 
session_start();
require_once __DIR__ . '/functions.php';

$user_id = $_GET["id"];
$conversation_id = $_SESSION['conversation_id'];

$statement = getDb() -> prepare("INSERT INTO group_member (user_id, conversation_id) VALUES (:user_id, :conversation_id);");
$statement -> execute([':user_id' => $user_id, ':conversation_id' => $conversation_id]);
?>