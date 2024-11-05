<?php
// Database connection parameters
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['name'], $_POST['role'], $_POST['salary'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO Employees (name, role, salary) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssd", $name, $role, $salary); // 'ssd' indicates string, string, decimal
        if ($stmt->execute()) {
            // Redirect back to manager dashboard after successful addition
            header("Location: managerm.html?success=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
} else {
    echo "Please fill in all fields.";
}

$conn->close();
?>
