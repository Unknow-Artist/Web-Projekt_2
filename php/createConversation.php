<?php
session_start();
require_once __DIR__ . '/functions.php';
header('Content-Type: application/json; charset=utf-8');

$user_id = $_SESSION["user_id"];
$name = htmlentities($_POST["name"]);

$db = getDb();
$statement1 = $db -> prepare("INSERT INTO conversation (name) VALUES (:name);");
$statement1 -> execute([':name' => $name]);

$conversation_id = $db -> lastInsertId();

$statement2 = $db -> prepare("INSERT INTO group_member (user_id, conversation_id) VALUES (:user_id, :conversation_id);");
$statement2 -> execute([':user_id' => $user_id, ':conversation_id' => $conversation_id]);
?>