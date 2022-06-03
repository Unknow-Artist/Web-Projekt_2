<?php
session_start();

require_once __DIR__ . '/functions.php';

$db = getDb();
$username = $_GET['username'];

if (empty($username)) {
    $userList = $db -> prepare("SELECT id, username FROM user WHERE id != :id LIMIT 10");
    $userList -> execute([':id' => $_SESSION['user_id']]);
} else {
    $userList = $db -> prepare("SELECT id, username FROM user WHERE username LIKE :username AND id != :id LIMIT 10");
    $userList -> execute([':username' => '%' . $username . '%', ':id' => $_SESSION['user_id']]);
}

foreach ($userList as $user) {
    echo <<<search
    <li class="list-group-item d-flex justify-content-between align-items-center">
        $user[username]
        <i class="bi bi-person-plus-fill"></i>
    </li>
    search;
}
?>