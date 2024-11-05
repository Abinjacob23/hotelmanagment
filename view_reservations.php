<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json"); // Set header to return JSON data

// Database connection parameters
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Fetch reservations
$sql = "SELECT r.category, res.check_in_date, res.check_out_date, res.guest_name 
        FROM Reservations res
        JOIN Rooms r ON res.room_id = r.id
        ORDER BY res.check_in_date ASC";

$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $conn->error, "query" => $sql]);
    exit;
}

// Prepare an array for rows
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row; // Store each row in the array
    }
}

// Output the array in JSON format
echo json_encode($rows);

$conn->close();
?>
