<?php 
// Hostname
$host = "localhost";
// Username
$uname = "root";
// Password
$pw = "";
// Database Name
$dbname = "simple_attendance_db.";

$conn = new mysqli($host, $uname, $pw, $dbname);

if(!$conn){
    die("Database Connection Failed: <br>" . mysqli_connect_error());
} 
return $conn;


