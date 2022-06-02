<?php 
require_once __DIR__ . '/functions.php';

$db = getDb();
$username = $_GET['username'];

$statement = $db -> prepare("SELECT id, username FROM user");
$statement -> execute();
$userList = $statement -> fetch();

foreach ($userList as $user) {
    echo <<<EOT
    <li>
        $user[username]
    </li>
    EOT;
}
?>