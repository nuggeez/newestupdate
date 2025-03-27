<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $facility_id = $_GET['id'];

    // Delete facility record
    $query = "DELETE FROM facilities WHERE facility_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $facility_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Facility deleted successfully!'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error deleting facility.'); window.location.href='users.php';</script>";
    }
}
?>
