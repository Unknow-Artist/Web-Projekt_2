<?php

session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;
require_once __DIR__ . '/functions.php';

$db = getDb();
$user_id = $_SESSION['user_id'];
$conversation_id = $_SESSION["conversation_id"];

$conversations = $db -> prepare("SELECT conversation_id, name FROM conversation INNER JOIN group_member ON conversation.id = group_member.conversation_id WHERE group_member.user_id = :user_id");
$conversations -> bindParam(':user_id', $user_id);
$conversations -> execute();

foreach($conversations as $conversation) {
    $messages = $db -> prepare("SELECT sender_id, text FROM message WHERE conversation_id = :conversation_id ORDER BY id DESC LIMIT 1");
    $messages -> bindParam(':conversation_id', $conversation['conversation_id']);
    $messages -> execute();
    $message = $messages -> fetch();

    if($messages -> rowCount() > 0) {
        $sender = getUserById($message['sender_id']);
        $text = $sender["username"] . ": " . $message["text"];
        if(strlen($message["text"]) > 32) $text = substr($text, 0, 32) . "...";
    } else {
        $text = "Keine Nachrichten";
    }

    if($conversation["conversation_id"] == $conversation_id) {
        $active = 'active';
    } else {
        $active = '';
    }

    echo <<<CONTACT
    <div class="list-group-item list-group-item-action py-3 chat-group $active" onClick="switchChat($conversation[conversation_id])">
        <strong>$conversation[name]</strong>
        <p class="m-0">$text</p>
    </div>
    CONTACT;
}
?>