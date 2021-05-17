<?php

$servername = "167.114.152.54";
$username = "chevalier3";
$password = "h96nz4b9";
$dbname="dbchevalersk3";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
