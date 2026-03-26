<?php
$servername = "mysql-200-140.mysql.prositehosting.net";
$username = "root_user";
$password = "8945fb38db165d92";
$dbname = "sql_acceleratespace";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>