<?php
// get_theaters.php

$host = "localhost";
$user = "root";
$password = ""; // default password for XAMPP
$database = "movie_db";

// Create connection
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch theaters (you can filter by movie if needed)
$sql = "SELECT name, location, seats_available FROM theaters";
$result = $conn->query($sql);

$theaters = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $theaters[] = $row;
  }
}

echo json_encode($theaters);
$conn->close();
?>
