<?php
// Enable CORS and allow JSON content
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

// Extract snack quantities
$popcorn = intval($data['popcorn'] ?? 0);
$drink = intval($data['drink'] ?? 0);
$nachos = intval($data['nachos'] ?? 0);
$combo = intval($data['combo'] ?? 0);

// Prices
$price_popcorn = 120;
$price_drink = 80;
$price_nachos = 100;
$price_combo = 250;

// Calculate total
$total = ($popcorn * $price_popcorn) + ($drink * $price_drink) + ($nachos * $price_nachos) + ($combo * $price_combo);

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "movie_db");

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Insert the data
$stmt = $conn->prepare("INSERT INTO snack_orders (popcorn, drink, nachos, combo, total) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiii", $popcorn, $drink, $nachos, $combo, $total);
$stmt->execute();
$stmt->close();
$conn->close();

// Send response
echo json_encode([
    "message" => "Snacks booked successfully",
    "booking" => [
        "total" => $total
    ]
]);
?>
