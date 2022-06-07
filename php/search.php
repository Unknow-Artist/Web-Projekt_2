<?php
session_start();

require_once __DIR__ . '/functions.php';

$db = getDb();
$username = htmlentities($_GET["username"]);

if (empty($username)) {
    $userList = $db -> prepare("SELECT id, username FROM user WHERE id != :id LIMIT 10");
    $userList -> execute([':id' => $_SESSION['user_id']]);
} else {
    $userList = $db -> prepare("SELECT user.id, user.username FROM user INNER JOIN group_member ON user.id = group_member.user_id WHERE user.username LIKE :username AND user.id != :id AND group_member.conversation_id = :conversation_id");
    $userList -> execute([
        ':id' => $_SESSION['user_id'],
        ':username' => '%' . $username . '%',
        ':conversation_id' => $_SESSION['conversation_id']
    ]);
}

foreach ($userList as $user) {
    if ($userList -> rowCount() == 0) {
        echo <<<search
        <li class="list-group-item d-flex justify-content-between align-items-center">
            $user[username]
            <i class="bi bi-person-plus-fill p-2" onclick="addUser($user[id])"></i>
        </li>
        search;
    }
}
?>