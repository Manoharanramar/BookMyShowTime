<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database config
$servername = "localhost";
$username = "root";
$password = "";
$database = "movie_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Debug: Check required fields
    if (empty($name) || empty($email) || empty($message)) {
        die("❌ Missing required fields.");
    }

    // Prepare SQL (using prepared statement to avoid SQL injection)
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute and check
    if (!$stmt->execute()) {
        die("❌ SQL Error: " . $stmt->error);
    }

    echo "✅ Message sent successfully!";
    $stmt->close();
}

$conn->close();
?>
