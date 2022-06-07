<?php
if(!(isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')){
    header('Location: ../index.php');
    exit;
}

session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$user_id = $_GET["id"];
$conversation_id = $_SESSION['conversation_id'];

$statement = getDb() -> prepare("INSERT INTO group_member (user_id, conversation_id) VALUES (:user_id, :conversation_id);");
$statement -> execute([':user_id' => $user_id, ':conversation_id' => $conversation_id]);
?>