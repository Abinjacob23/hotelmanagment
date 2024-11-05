<?php
// Database connection parameters
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all employees, including their id
$sql = "SELECT id, name, role, salary FROM Employees";
$result = $conn->query($sql);

$employees = array();

// Check if there are results and fetch data
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($employees);

// Close the database connection
$conn->close();
?>
