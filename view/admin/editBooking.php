<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);

    // Query with joins as specified
    $query = "SELECT 
                bookings.booking_id, 
                CONCAT(users.firstName, ' ', users.lastName) AS full_name, 
                bookings.guest_id, 
                bookings.check_in_date, 
                bookings.check_out_date, 
                bookings.number_of_guests,
                users.gender,
                users.phoneNumber,  
                users.email, 
                rooms.room_number, 
                payments.status AS payment_status
              FROM 
                bookings
              INNER JOIN guests ON bookings.guest_id = guests.guest_id
              INNER JOIN users ON guests.user_id = users.userId
              INNER JOIN rooms ON bookings.room_id = rooms.room_id
              LEFT JOIN payments ON bookings.payment_id = payments.payment_id
              WHERE bookings.booking_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $reservation = mysqli_fetch_assoc($result);

        if (!$reservation) {
            echo "<script>alert('Booking not found!'); window.location.href='reservation.php';</script>";
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error fetching booking data!'); window.location.href='reservation.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='reservation.php';</script>";
    exit();
}

if (isset($_POST['update_booking'])) {
    $guest_name = $_POST['guest_name'];
    $gender = $_POST['gender'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $room_number = $_POST['room_number'];
    $payment_status = $_POST['payment_status'];
    $number_of_guests = $_POST['number_of_guests'];

    $query = "UPDATE bookings 
              INNER JOIN guests ON bookings.guest_id = guests.guest_id
              INNER JOIN users ON guests.user_id = users.userId
              INNER JOIN rooms ON bookings.room_id = rooms.room_id
              LEFT JOIN payments ON bookings.payment_id = payments.payment_id
              SET 
                bookings.check_in_date = ?, 
                bookings.check_out_date = ?, 
                bookings.number_of_guests = ?, 
                users.phoneNumber = ?, 
                users.email = ?, 
                payments.status = ?
              WHERE bookings.booking_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisisi", $check_in, $check_out, $number_of_guests, $phone_number, $email, $payment_status, $booking_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Booking updated successfully!'); window.location.href='reservation.php';</script>";
        } else {
            echo "<script>alert('Error updating booking: " . mysqli_stmt_error($stmt) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Booking</h5>
            <form method="POST">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Guest Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="guest_name" class="form-control" value="<?= htmlspecialchars($reservation['full_name']); ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        <input type="text" name="gender" class="form-control" value="<?= htmlspecialchars($reservation['gender']); ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-in Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_in" class="form-control" value="<?= htmlspecialchars($reservation['check_in_date']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-out Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_out" class="form-control" value="<?= htmlspecialchars($reservation['check_out_date']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($reservation['phoneNumber']); ?>" required>
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
                        <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($reservation['room_number']); ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Number of Guests</label>
                    <div class="col-sm-10">
                        <input type="number" name="number_of_guests" class="form-control" value="<?= htmlspecialchars($reservation['number_of_guests']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Payment Status</label>
                    <div class="col-sm-10">
                        <select name="payment_status" class="form-select" required>
                            <option value="Pending" <?= ($reservation['payment_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Completed" <?= ($reservation['payment_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Failed" <?= ($reservation['payment_status'] == 'Failed') ? 'selected' : ''; ?>>Failed</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update_booking" class="btn btn-primary">Update Booking</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
