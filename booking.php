<?php
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP MySQL password is empty
$dbname = "movie_db";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$movie = $_POST['movie'];
$date = $_POST['date'];
$time = $_POST['time'];
$seats = $_POST['seats'];

// Insert into database
$sql = "INSERT INTO bookings (name, movie, date, time, seats) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $movie, $date, $time, $seats);

if ($stmt->execute()) {
  echo "Booking successful!";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
