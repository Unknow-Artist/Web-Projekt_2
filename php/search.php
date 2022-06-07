<?php
if(!(isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')){
    header('Location: ../index.php');
    exit;
}

session_start();
if(empty($_SESSION["user_id"]) || empty($_SESSION["username"]) || empty($_SESSION["conversation_id"])) exit;

require_once __DIR__ . '/functions.php';

$db = getDb();
$username = htmlentities($_GET["username"]);
$conversation_id = $_SESSION["conversation_id"];

$userList = $db -> prepare("SELECT id, username FROM user WHERE user.id != :id LIMIT 10");
$userList -> execute([':id' => $_SESSION['user_id']]);

foreach ($userList as $user) {
    $statement = $db -> prepare("SELECT id FROM group_member WHERE user_id = :user_id AND conversation_id = :conversation_id");
    $statement -> execute([':user_id' => $user['id'], ':conversation_id' => $conversation_id]);
    if ($statement -> rowCount() == 0) {
        echo <<<search
        <li class="list-group-item d-flex justify-content-between align-items-center">
            $user[username]
            <i class="bi bi-person-plus-fill p-2" onclick="addUser($user[id])"></i>
        </li>
        search;
    }
}
?>