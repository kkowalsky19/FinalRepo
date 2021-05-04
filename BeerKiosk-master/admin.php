<?php
session_start();

if ($_SESSION['loggedin']==false)
{
    header ("Location: adminlogin.html");
    die();
}

require 'config.php';
$stmt = $mysqli->prepare("select snackPrice, status, snackName from general where id=1");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();


$stmt->bind_result($snackPrice,$status,$typeSnack);



while($stmt->fetch()){
  //echo "<script>console.log( 'Snack Objects: " . $snackPrice . "' );</script>";
}
$stmt->close();




?> 
    
    <html lang="en">
        <body>
            <h1>Enter Details: </h1> 
            <form action="adminSubmit.php" method="post">
                <p>Type of snack: (Currently- <b><?php echo $typeSnack; ?></b> )</p>
                <input type="text" name="nameSnack">
                <input type="submit" value="Update Name">
            </form>
            <br>

            <form action="adminSubmit.php" method="post">
                <p>Cost of Snack: (Currently- <b><?php echo $snackPrice; ?></b>) </p>
                <input type="text" name="costSnack">
                <input type="submit" value="Update Cost">
            </form>

            <form action="adminSubmit.php" method="post">
                <p>Status: 1 = On | 0 = Off Currently- (<b><?php echo $status; ?></b>)</p>
                <input type="text" name="status">
                <input type="submit" value="Update Status">
            </form>

            <form action="logout.php">
                <input type="submit" value="Log out">
            </form>
            
    
        </body>
    </html>