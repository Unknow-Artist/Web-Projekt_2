<?php 
if(empty($_POST["password"])) {
    echo "Please enter a password";
    exit;
}
echo $_POST["password"];
?>