<?php 
require_once __DIR__ . '/functions.php';

$db = getDb();
$username = htmlentities($_GET["username"]);

if(empty($username)) {
    $userList = $db -> prepare("SELECT id, username FROM user");
    $userList -> execute();
} else {
    $userList = $db -> prepare("SELECT id, username FROM user WHERE username LIKE :username");
    $userList -> execute([':username' => "%$username%"]);
}

foreach ($userList as $user) {
    echo <<<ListItem
    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
        $user[username]
        <i class="bi bi-plus-lg"></i>
    </li>
    ListItem;
}

// 
?>