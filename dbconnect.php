<?php
$servername = "db_servername";
$username = "db_username";
$password = "db_password";
$dbname = "db_name";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
