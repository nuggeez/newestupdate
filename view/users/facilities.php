<?php
include("../../auth/authenticationForUser.php");
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['facility'], $_POST['reservationDate'], $_POST['startTime'], $_POST['endTime'], $_POST['paymentMethod'])) {
        die("All fields are required.");
    }

    $facility_id = $_POST['facility'];
    $preferred_date = $_POST['reservationDate'];
    $start_time = $_POST['startTime'];
    $end_time = $_POST['endTime'];
    $payment_method = $_POST['paymentMethod'];

    if (!isset($_SESSION['authUser']['userId'])) {
        die("User not logged in.");
    }

    $userId = $_SESSION['authUser']['userId'];

    // Validate if the selected facility ID exists in the database
    $facilityCheckQuery = "SELECT facility_id FROM facilities WHERE facility_id = ?";
    $stmt = $conn->prepare($facilityCheckQuery);
    $stmt->bind_param("i", $facility_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid facility selected.");
    }

    // Check if the user is already a guest
    $query = "SELECT guest_id FROM guests WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $guest = $result->fetch_assoc();

    if ($guest) {
        $guest_id = $guest['guest_id'];
    } else {
        $insertGuest = "INSERT INTO guests (user_id) VALUES (?)";
        $stmt = $conn->prepare($insertGuest);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $guest_id = $stmt->insert_id;
    }

    // Insert the facility reservation
    $insertReservation = "INSERT INTO facility_reservations 
                      (guest_id, facility_id, preferred_date, preferred_start_time, preferred_end_time) 
                      VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertReservation);
    $stmt->bind_param("iisss", $guest_id, $facility_id, $preferred_date, $start_time, $end_time);

    if ($stmt->execute()) {
        echo "<script>alert('Facility reserved successfully.'); window.location.href='facilities.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<section class="section">
    <div class="row">
        <!-- Facility Reservations Table -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Facility Reservations</h5>
                    <p>Reserve our premium hotel facilities to enhance your stay at Lume Manor. Whether you're looking for a relaxing spa, a fully equipped gym, or a luxurious swimming pool, we offer top-tier amenities to make your experience unforgettable.</p>

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Facility</th>
                                <th>Description</th>
                                <th>Price (PHP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Spa & Wellness</td>
                                <td>Access to sauna, jacuzzi, and massage therapy</td>
                                <td>1,500.00</td>
                            </tr>
                            <tr>
                                <td>Swimming Pool</td>
                                <td>Day pass for pool access with towel service</td>
                                <td>500.00</td>
                            </tr>
                            <tr>
                                <td>Fitness Center</td>
                                <td>Gym access with personal trainer (optional)</td>
                                <td>800.00</td>
                            </tr>
                            <tr>
                                <td>Conference Room</td>
                                <td>Meeting space with audio-visual setup</td>
                                <td>2,000.00/hour</td>
                            </tr>
                            <tr>
                                <td>Event Hall</td>
                                <td>Spacious hall for weddings, parties, and corporate events</td>  
                                <td>5,000.00/hour</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Facility Reservation Form -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reserve a Facility</h5>
                    <form method="POST" action="facilities.php">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Facility</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="facility" required> <!-- Added name attribute -->
                                    <option value="" selected disabled>Select Facility</option>
                                    <option value="1">Spa & Wellness</option>
                                    <option value="2">Swimming Pool</option>
                                    <option value="3">Fitness Center</option>
                                    <option value="4">Conference Room</option>
                                    <option value="5">Event Hall</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="reservationDate" class="col-sm-2 col-form-label">Preferred Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="reservationDate" name="reservationDate" required> <!-- Fixed name -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="startTime" class="col-sm-2 col-form-label">Start Time</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="startTime" name="startTime" required> <!-- Fixed name -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="endTime" class="col-sm-2 col-form-label">End Time</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="endTime" name="endTime" required> <!-- Fixed name -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Payment Method</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="paymentMethod" required> <!-- Fixed name -->
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Pay at Hotel">Pay at Hotel</option>
                                </select>
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
    </div>
</section>

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