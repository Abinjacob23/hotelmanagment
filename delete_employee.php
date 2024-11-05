<?php
// Database connection parameters
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Prepare the delete statement
    $sql = "DELETE FROM Employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $employee_id); // 'i' indicates that the parameter is an integer
        if ($stmt->execute()) {
            // Redirect back to manager dashboard after successful deletion
            header("Location: managerm.html?delete_success=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
} else {
    echo "No employee ID provided.";
}

// Close the database connection
$conn->close();
?>
