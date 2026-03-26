<?php
$servername = "localhost";
$username = "sql_rinza";
$password = "cnij4fWHSGfa2bJS";
$dbname = "sql_rinza";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>