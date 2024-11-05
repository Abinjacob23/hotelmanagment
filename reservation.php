<?php 
$conn = new mysqli("sql305.infinityfree.com", "if0_37643302", "azwi1I3J8H", "if0_37643302_hm");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete old reservations
$sql = "DELETE FROM Reservations WHERE check_out_date < CURDATE()";
$conn->query($sql);

// Reset room availability based on active reservations
$reset_sql = "UPDATE Rooms SET availability = 1";
$conn->query($reset_sql);

// Update room availability based on current reservations
$update_sql = "
    UPDATE Rooms 
    SET availability = 0 
    WHERE id IN (
        SELECT room_id 
        FROM Reservations 
        WHERE check_out_date >= CURDATE()
        GROUP BY room_id 
        HAVING COUNT(*) >= 3
    )";
$conn->query($update_sql);

// Check if room type is set for price fetching
if (isset($_GET['room_type'])) {
    $room_type = $_GET['room_type'];

    // Fetch the price for the specified room type
    $sql = "SELECT price FROM Rooms WHERE category = ? AND availability = 1 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $room_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        echo json_encode(['price' => $room['price']]);
    } else {
        echo json_encode(['price' => null]); // No available room found
    }
    $stmt->close();
}

$conn->close();
?>
