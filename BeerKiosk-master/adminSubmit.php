<?php
session_start();
//include 'header.html';
if ($_SESSION['loggedin']==false)
{
    header ("Location: adminlogin.html");
    die();
}

$nameSnack = $_POST["nameSnack"];
$costSnack = $_POST["costSnack"];
$status = $_POST["status"];


require 'config.php';

if(strlen($nameSnack) > 0){
    $stmt = $mysqli->prepare("update general SET snackName = ? WHERE id=1");
}
if(strlen($costSnack) > 0){
    $stmt = $mysqli->prepare("update general SET snackPrice = ? WHERE id=1");
}
if(strlen($status) > 0){
    $stmt = $mysqli->prepare("update general SET status = ? WHERE id=1");
}


if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
if(strlen($nameSnack) > 0){
    $stmt->bind_param('s', $nameSnack);
}
if(strlen($costSnack) > 0){
    $stmt->bind_param('s', $costSnack);
}
if(strlen($status) > 0){
    $stmt->bind_param('s', $status);
}

$stmt->execute();
$stmt->close();
header('Location: admin.php');
?>

<html lang="en">
    <form action="logout.php">
        <input type="submit" value="Log out">
    </form>
</html>