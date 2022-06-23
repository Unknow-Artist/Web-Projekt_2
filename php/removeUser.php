<?php
session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$user_id = $_GET["id"];
$conversation_id = $_SESSION['conversation_id'];

$statement = getDb() -> prepare("DELETE FROM group_member WHERE user_id = :user_id AND conversation_id = :conversation_id;");
$statement -> execute([':user_id' => $user_id, ':conversation_id' => $conversation_id]);
?>