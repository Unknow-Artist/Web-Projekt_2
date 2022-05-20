<?php 
if(isset($_GET['speichern'])){
    $name = htmlspecialchars($_GET['username']);
    $isbn = htmlspecialchars($_GET['password']);
    $preis = htmlspecialchars($_GET['email']);

    // Datenbank-Verbindung aufbauen, Datenbank wählen
    require_once('../inc/db_inc.php');
    require_once('../inc/connect.php');

    // Datensatz speichern
    $query = "INSERT INTO user
            (username, password, email)
            VALUES ('$username', '$password', '$email')";
    $db -> exec($query);
    }

    header('Content-Type: text/html; charset=utf-8');

    
?>