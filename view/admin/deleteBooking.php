<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);  // Ensuring `id` is cast to an integer for security.

    // Start a transaction in case multiple related deletions are needed.
    mysqli_begin_transaction($conn);

    try {
        // First, delete the related payment (if any).
        $deletePaymentQuery = "DELETE payments FROM payments 
                               INNER JOIN bookings ON payments.payment_id = bookings.payment_id 
                               WHERE bookings.booking_id = ?";
        $paymentStmt = mysqli_prepare($conn, $deletePaymentQuery);
        mysqli_stmt_bind_param($paymentStmt, "i", $booking_id);
        mysqli_stmt_execute($paymentStmt);
        mysqli_stmt_close($paymentStmt);

        // Then, delete the booking itself.
        $deleteBookingQuery = "DELETE FROM bookings WHERE booking_id = ?";
        $bookingStmt = mysqli_prepare($conn, $deleteBookingQuery);
        mysqli_stmt_bind_param($bookingStmt, "i", $booking_id);
        mysqli_stmt_execute($bookingStmt);
        mysqli_stmt_close($bookingStmt);

        // Commit the transaction if both deletions are successful.
        mysqli_commit($conn);

        echo "<script>alert('Booking and related payment deleted successfully!'); window.location.href='reservation.php';</script>";
    } catch (Exception $e) {
        // Roll back the transaction if any error occurs.
        mysqli_rollback($conn);
        echo "<script>alert('Error deleting booking: " . $e->getMessage() . "'); window.location.href='reservation.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='reservation.php';</script>";
}

?>
