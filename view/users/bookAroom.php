<?php
include("../../auth/authenticationForUser.php");
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $roomType = $_POST['roomType'];
    $paymentMethod = $_POST['paymentMethod'];
    $numberOfGuests = $_POST['numberOfGuests'];

    // Ensure user is logged in
    if (!isset($_SESSION['authUser']['userId'])) {
        die("User not logged in.");
    }
    $userId = $_SESSION['authUser']['userId'];


    // Step 1: Insert user into the guests table if not already a guest
    $checkGuestQuery = "SELECT guest_id FROM guests WHERE user_id = '$userId'";
    $guestResult = mysqli_query($conn, $checkGuestQuery);

    if (!$guestResult) {
        die("Error checking guest status: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($guestResult) == 0) {
        // User is not a guest yet, insert into guests table
        $insertGuestQuery = "INSERT INTO guests (user_id) VALUES ('$userId')";
        if (!mysqli_query($conn, $insertGuestQuery)) {
            die("Error inserting into guests table: " . mysqli_error($conn));
        }
        $guestId = mysqli_insert_id($conn); // Get the newly inserted guest ID
    } else {
        // User is already a guest, fetch guest ID
        $guestRow = mysqli_fetch_assoc($guestResult);
        $guestId = $guestRow['guest_id'];
    }



    // Step 2: Get an available room of the selected type
    $roomQuery = "SELECT room_id, capacity FROM rooms WHERE room_type = '$roomType' AND status = 'Available' ORDER BY RAND() LIMIT 1";
    $roomResult = mysqli_query($conn, $roomQuery);

    if (!$roomResult || mysqli_num_rows($roomResult) == 0) {
        die("No available rooms of type '$roomType'.");
    }

    $roomData = mysqli_fetch_assoc($roomResult);
    $roomId = $roomData['room_id'];

    // Check if number of guests exceeds room capacity
    if ($numberOfGuests > $roomData['capacity']) {
        die("Number of guests exceeds room capacity.");
    }




    // Step 3: Create payment record (optional, depending on your flow)
    $insertPaymentQuery = "INSERT INTO payments (guest_id, amount, payment_method, status) VALUES ('$guestId', 0, '$paymentMethod', 'Pending')";
    if (!mysqli_query($conn, $insertPaymentQuery)) {
        die("Error creating payment record: " . mysqli_error($conn));
    }
    $paymentId = mysqli_insert_id($conn);



    // Step 4: Insert booking into the bookings table
    $insertBookingQuery = "INSERT INTO bookings 
                          (guest_id, room_id, check_in_date, check_out_date, number_of_guests, payment_id, created_at) 
                          VALUES ('$guestId', '$roomId', '$checkIn', '$checkOut', '$numberOfGuests', '$paymentId', NOW())";

    if (mysqli_query($conn, $insertBookingQuery)) {
        // Update room status to Occupied
        $updateRoomQuery = "UPDATE rooms SET status = 'Occupied' WHERE room_id = '$roomId'";
        mysqli_query($conn, $updateRoomQuery);
        
        echo "<script>alert('Booking successful!'); window.location.href='bookAroom.php';</script>";
    } else {
        die("Error creating booking: " . mysqli_error($conn));
    }

    // Close database connection
    mysqli_close($conn);
}
?>

<!-- HTML Form for Booking -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Find Your Perfect Stay</h5>
            <form method="POST" action="bookAroom.php">
                <div class="row mb-3">
                    <label for="checkIn" class="col-sm-2 col-form-label">Check-IN Date</label>
                    <div class="col-sm-10">
                        <input type="date" id="checkIn" class="form-control" name="checkIn" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="checkOut" class="col-sm-2 col-form-label">Check-OUT Date</label>
                    <div class="col-sm-10">
                        <input type="date" id="checkOut" class="form-control" name="checkOut" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="roomType" class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="roomId" name="roomType" required>
                            <option selected disabled>Select Room Type</option>
                            <option value="Single">Single Room</option>
                            <option value="Double">Double Room</option>
                            <option value="Suite">Suite Room</option>
                            <option value="Family">Family Room</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="numberOfGuests" class="col-sm-2 col-form-label">Number of Guests</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="numberOfGuests" name="numberOfGuests" required>
                            <option selected disabled>Number of Guests</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="paymentMethod" class="col-sm-2 col-form-label">Payment Method</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option selected disabled>Select Payment Method</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Pay at Hotel">Pay at Hotel</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Terms & Conditions</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" required>
                            <label class="form-check-label">
                                I agree to the terms and conditions of Lume Manor.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
  body {
    background-color: #F4F7EF;
  }
  /* Set font color */
  body, h1, h2, h3, h4, h5, h6, p, label, .form-label {
      color: #1e1e1e !important;
  }

  /* Change active text color */
  a, a:hover, a:focus {
      color: #BB9C34 !important;
  }

  /* Change button color */
  .btn-primary {
      background-color: #FBC741 !important;
      border-color: #FBC741 !important;
      color: #1e1e1e !important;
  }

  /* Button hover effect */
  .btn-primary:hover {
      background-color: #e0a830 !important;
      border-color: #e0a830 !important;
  }
</style>

<?php
include("./includes/footer.php");
?>