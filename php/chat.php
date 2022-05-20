<?php
$host = 'localhost';
$database = 'updog';
$usr = 'root';
$pass = '';
$dns = $dns = 'mysql:host=' . $host . ';dbname=' . $database;
$db = new PDO($dns, $usr, $pass);

if (isset($_POST["submit"])) {
    $message = $_POST["message"];
    $db -> query("INSERT INTO message (user_id, text) VALUES ('1', '$message')");
}

?>
<!DOCTYPE html>
<html lang="de-CH">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <form action="chat.php" method="post">
        <label>
            Name
            <input type="text" name="name">
        </label>
        <label>
            Nachricht
            <input type="text" name="message">
        </label>
        <input type="submit" name="submit" value="Senden">
    </form>
</body>
</html>