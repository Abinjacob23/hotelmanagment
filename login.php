<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT * FROM Managers WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password (ensure you are storing hashed passwords)
       if ($password === $row['password']) {
            header("Location: managerm.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); 
            window.location.href='manager.html';</script>";
        }
    } else {
        echo "<script>alert('Username not found. Please try again.'); 
        window.location.href='manager.html';</script>";
    }

    $stmt->close();
} else {
    echo "Please provide both username and password.";
}

$conn->close();
?>
