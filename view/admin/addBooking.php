<?php
include("../../dB/config.php"); 
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Fetch guests for dropdown
$guests_result = $conn->query("SELECT guest_id, name FROM guests");

// Fetch rooms for dropdown
$rooms_result = $conn->query("SELECT room_id, room_number, room_type FROM rooms");

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $guest_id = $_POST['guest_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $meal = $_POST['meal'];
    $payment_status = $_POST['payment_status'];
    $reservation_status = $_POST['reservation_status'];

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO reservations (guest_id, room_id, check_in, check_out, meal, payment_status, reservation_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $guest_id, $room_id, $check_in, $check_out, $meal, $payment_status, $reservation_status);

    // Execute query
    if ($stmt->execute()) {
        echo "<script>alert('Booking added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding booking.');</script>";
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Booking</h5>

            <!-- Booking Form -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Guest</label>
                    <div class="col-sm-10">
                        <select name="guest_id" class="form-select" required>
                            <option selected disabled>Select Guest</option>
                            <?php while ($guest = $guests_result->fetch_assoc()) { ?>
                                <option value="<?= $guest['guest_id'] ?>"><?= $guest['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room</label>
                    <div class="col-sm-10">
                        <select name="room_id" class="form-select" required>
                            <option selected disabled>Select Room</option>
                            <?php while ($room = $rooms_result->fetch_assoc()) { ?>
                                <option value="<?= $room['room_id'] ?>">
                                    <?= "Room " . $room['room_number'] . " (" . $room['room_type'] . ")" ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-in Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_in" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Check-out Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="check_out" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Meal Option</label>
                    <div class="col-sm-10">
                        <select name="meal" class="form-select" required>
                            <option value="no meal">No Meal</option>
                            <option value="with meal">With Meal</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Payment Status</label>
                    <div class="col-sm-10">
                        <select name="payment_status" class="form-select" required>
                            <option value="Paid">Paid</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Reservation Status</label>
                    <div class="col-sm-10">
                        <select name="reservation_status" class="form-select" required>
                            <option value="Checked In">Checked In</option>
                            <option value="Checked Out">Checked Out</option>
                            <option value="Booked">Booked</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Submit</label>
                    <div class="col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary">Submit Booking</button>
                    </div>
                </div>
            </form>
            <!-- End Booking Form -->
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
