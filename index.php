<?php
session_start();

require_once('php/functions.php');

if (empty($_SESSION['user_id']) && empty($_SESSION["username"]) && empty($_SESSION['conversation_id'])) {
    header("Location: signin.php");
    exit;
}

include_once('html/index.html');