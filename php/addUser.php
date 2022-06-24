<?php
session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$db = getDb();
$user_id = $_GET["id"];
$conversation_id = $_SESSION['conversation_id'];

$statement = $db -> prepare("INSERT INTO group_member (user_id, conversation_id) VALUES (:user_id, :conversation_id);");
$statement -> execute([':user_id' => $user_id, ':conversation_id' => $conversation_id]);

$db = null;
?>