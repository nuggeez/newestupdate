<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

if (isset($_GET['id'])) {
    $reservation_id = intval($_GET['id']);

    $query = "SELECT r.*, g.name, g.gender, g.phone_number, g.email, rm.room_number, rm.room_type, r.payment_status, r.reservation_status 
    FROM reservations r
    JOIN guests g ON r.guest_id = g.guest_id
    JOIN rooms rm ON r.room_id = rm.room_id
    WHERE r.reservation_id = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $reservation_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reservation = mysqli_fetch_assoc($result);

    if (!$reservation) {
        echo "<script>alert('Reservation not found!'); window.location.href='reservation.php';</script>";
        exit();
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Error fetching reservation data!'); window.location.href='reservation.php';</script>";
    exit();
}

} else {
echo "<script>alert('Invalid request!'); window.location.href='reservation.php';</script>";
exit();
}

if (isset($_POST['update_reservation'])) {
    $guest_name = $_POST['guest_name'];
    $gender = $_POST['gender'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $payment_status = $_POST['payment_status'];
    $reservation_status = $_POST['reservation_status'];

    $query = "UPDATE reservations SET check_in=?, check_out=?, payment_status=?, reservation_status=? WHERE reservation_id=?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $check_in, $check_out, $payment_status, $reservation_status, $reservation_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Reservation updated successfully!'); window.location.href='reservation.php';</script>";
        } else {
            echo "<script>alert('Error updating reservation: " . mysqli_stmt_error($stmt) . "');</script>";
        }        
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Reservation</h5>
            <form method="POST">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Guest Name</label>
                    <div class="col-sm-10">
                    <input type="text" name="guest_name" class="form-control" value="<?= isset($reservation['name']) ? htmlspecialchars($reservation['name']) : ''; ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        <select name="gender" class="form-select" required>
                            <option value="Male" <?= ($reservation['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?= ($reservation['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-in</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_in" class="form-control" value="<?= htmlspecialchars($reservation['check_in']); ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-out</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_out" class="form-control" value="<?= htmlspecialchars($reservation['check_out']); ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($reservation['phone_number']); ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($reservation['email']); ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room Number</label>
                    <div class="col-sm-10">
                        <input type="number" name="room_number" class="form-control" value="<?= htmlspecialchars($reservation['room_number']); ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-10">
                        <select name="room_type" class="form-select" required>
                            <option value="Standard" <?= ($reservation['payment_status'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
                            <option value="Deluxe" <?= ($reservation['payment_status'] == 'Deluxe') ? 'selected' : ''; ?>>Deluxe</option>
                            <option value="Suite" <?= ($reservation['payment_status'] == 'Suite') ? 'selected' : ''; ?>>Suite</option>
                            <option value="Family" <?= ($reservation['payment_status'] == 'Family') ? 'selected' : ''; ?>>Family</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Payment Status</label>
                    <div class="col-sm-10">
                        <select name="payment_status" class="form-select" required>
                            <option value="Paid" <?= ($reservation['payment_status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                            <option value="Unpaid" <?= ($reservation['payment_status'] == 'Unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                            <option value="Cancelled" <?= ($reservation['payment_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Reservation Status</label>
                    <div class="col-sm-10">
                        <select name="reservation_status" class="form-select" required>
                            <option value="Checked_In" <?= ($reservation['reservation_status'] == 'Checked_In') ? 'selected' : ''; ?>>Checked In</option>
                            <option value="Checked_Out" <?= ($reservation['reservation_status'] == 'Checked_Out') ? 'selected' : ''; ?>>Checked Out</option>
                            <option value="Cancelled" <?= ($reservation['reservation_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="Booked" <?= ($reservation['reservation_status'] == 'Booked') ? 'selected' : ''; ?>>Booked</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update_reservation" class="btn btn-primary">Update Reservation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
