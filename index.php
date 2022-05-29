<?php
session_start();

require_once('php/functions.php');

if (!isUserLoggedIn()) {
    header("Location: signin.php");
}

include_once('html/index.html');