<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $room_id = intval($_GET['id']); // Ensure it's an integer to prevent SQL injection

    $query = "DELETE FROM rooms WHERE room_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $room_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Room deleted successfully!'); window.location.href='availableRooms.php';</script>";
        } else {
            echo "<script>alert('Error deleting room!'); window.location.href='availableRooms.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error preparing query!'); window.location.href='availableRooms.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='availableRooms.php';</script>";
}
?>
