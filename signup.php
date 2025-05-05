<?php
// signup.php
$conn = new mysqli("localhost", "root", "", "movie_db");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if user already exists
$result = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($result->num_rows > 0) {
    echo "❌ Email already registered!";
    exit();
}

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);
if ($stmt->execute()) {
    echo "✅ Signup successful!";
} else {
    echo "❌ Signup failed!";
}
?>
