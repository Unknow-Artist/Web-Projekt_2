<?php 
if(isset($_GET['speichern'])){
    $username = htmlspecialchars($_GET['username']);
    $password = htmlspecialchars($_GET['password']);
    $email = htmlspecialchars($_GET['email']);

    // Datenbank-Verbindung aufbauen, Datenbank wählen
    require_once('db_inc.php');
    require_once('connect.php');

    // Datensatz speichern
    $query = "INSERT INTO user
            (username, password, email)
            VALUES ('$username', '$password', '$email')";
    $db -> exec($query);
    }

    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="den-CH">
<head>
    <meta charset="UTF-8">
    <title>Neuer User erstellen</title>
</head>
<body>
   <h1>Neuer user erstellen</h1> 

   <section>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" accept-charset="utf-8">
            <p class="mit_lable">
                <label for="username">Usernaem:</label>
                <input type="text" class="admin" name="username" id="username" autofocus>
            </p>
            <p class="mit_lable">
                <label for="password">Password:</label>
                <input type="password" class="admin" name="password" id="password">
            </p>
            <p class="mit_lable">
                <label for="username">email:</label>
                <input type="email" class="admin" name="email" id="email">
            </p>
            <p class="ohne_lable">
                <input type="submit" value="speichern" name="speichern">
            </p>
        </form>
    </section>
</body>
</html>