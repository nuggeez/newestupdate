<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Prepare delete query
    $query = "DELETE FROM reservations WHERE reservation_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $reservation_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Reservation deleted successfully!'); window.location.href='reservation.php';</script>";
    } else {
        echo "Error deleting reservation: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
