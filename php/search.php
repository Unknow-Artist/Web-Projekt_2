<?php 
require_once __DIR__ . '/functions.php';

$db = getDb();
$username = $_GET['username'];

if (empty($username)) {
    $userList = $db -> prepare("SELECT id, username FROM user");
} else {
    $userList = $db -> prepare("SELECT id, username FROM user WHERE username LIKE :username");
    $userList -> bindParam(':username', '%' . $username . '%');
}

$userList -> execute();

foreach ($userList as $user) {
    echo <<<search
    <li class="list-group-item d-flex justify-content-between align-items-center">
        $user[username]
    </li>
    search;
}
?>