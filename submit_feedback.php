<?php
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['guest_name'], $_POST['rating'])) {
    $guest_name = $_POST['guest_name'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO Feedback (guest_name, rating) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $guest_name, $rating);
        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully!'); window.location.href='index.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
} else {
    echo "<script>alert('Please fill in all fields.'); window.location.href='feedback.html';</script>";
}

$conn->close();
?>
