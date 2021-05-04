<?php



//IN DATABASE CREATE A DATABASE CALLED mod3 THEN CREATE A USER FOR mod3 WITH THE USERNAME OF: mod3 AND PASSWORD OF mod3 then in phpmyadmin import the mod3.sql file thats located in the repo into your mod3 database.


$mysqli = new mysqli('localhost', 'beerkios_froggs', 'Froggies123!', 'beerkios_froggs');

if($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
}



?>