<?php
require_once('php/functions.php');

session_start();

if (!isUserLoggedIn()) header("Location: signin.php");
$userData = getUserData($_SESSION["user_id"]);
include_once('html/index.html');
