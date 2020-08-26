<?php

// $servername = "pdb37.runhosting.com";
// $username = "3074254_crm";
// $password = "crm12341";
// $dbname = "3074254_crm";

// // Create connection
// $con = mysqli_connect($servername, $username, $password,$dbname);

// // Check connection
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// mysqli_query($con, "SET CHARACTER SET UTF8");


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "crm_db";

// Create connection
$con = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_query($con, "SET CHARACTER SET UTF8");
?>
