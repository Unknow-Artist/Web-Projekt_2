<?php 
if (isset($_POST["sendMessage"]) && !empty($_POST["message"])) {
    $message = htmlentities($_POST["message"]);
    $user_id = $userData["id"];

    $statement = $db -> prepare("INSERT INTO message (sender_id, text, conversation_id) VALUES (:sender_id, :text, :conversation_id);");
    $statement -> bindParam(':sender_id', $user_id);
    $statement -> bindParam(':text', $message);
    $statement -> bindParam(':conversation_id', $conversation_id);
    $statement -> execute();
}
?>