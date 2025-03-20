<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $guest_id = $_GET['id'];

    // Delete guest record
    $query = "DELETE FROM guests WHERE guest_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $guest_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Guest deleted successfully!'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error deleting guest.'); window.location.href='users.php';</script>";
    }
}
?>
