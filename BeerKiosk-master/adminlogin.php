<?php
session_start();

$user = $_POST["user"];
$pass = $_POST["pass"];
$success = false; 
$_SESSION['loggedin']=false;
$_SESSION['userid']='0';



require 'config.php';

// This is a *good* example of how you can implement password-based user authentication in your web application.

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT pass FROM users WHERE user=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$stmt->execute();

// Bind the results
$stmt->bind_result($encry);
$stmt->fetch();






if(password_verify($pass, $encry)){
    // Login succeeded!
    $_SESSION['user'] = $user;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    
    //assign session id id from sql
    $stmt->close();

    // Use a prepared statement
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE user=?");

    // Bind the parameter
    $stmt->bind_param('s', $user);
    $stmt->execute();

    // Bind the results
    $stmt->bind_result($userid);
    $stmt->fetch();
    $_SESSION['userid'] = $userid;

    $_SESSION['loggedin']=true;
    // Redirect to your target page
    header('Location: admin.php');



} else{
    // Login failed; redirect back to the login screen
    echo "Wrong Username/Password";
    header('Location: adminlogin.html');
}


?>