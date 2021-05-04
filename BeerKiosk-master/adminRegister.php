<?php
$user = $_POST["user"];
$pass = password_hash($_POST["pass"], PASSWORD_BCRYPT);
$success = false; 
        
            require 'config.php';

$stmt = $mysqli->prepare("insert into users (user, pass) values (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ss', $user, $pass);
$stmt->execute();
$stmt->close();
header('Location: adminlogin.html');
        

?>