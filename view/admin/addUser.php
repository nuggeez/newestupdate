<?php
include("../../dB/config.php"); // Include database connection
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $guest_name = $_POST['guest_name'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO guests (name, gender, phone_number, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $guest_name, $gender, $phone_number, $email);

    // Execute query
    if ($stmt->execute()) {
        echo "<script>alert('Guest added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding guest.');</script>";
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
            <h5 class="card-title">Add Guests</h5>

            <!-- General Form Elements -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <label for="guest_name" class="col-sm-2 col-form-label">Guest Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="guest_name" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        <select name="gender" class="form-select" required>
                            <option selected disabled>Select gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Submit</label>
                    <div class="col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary">Submit Form</button>
                    </div>
                </div>
            </form>
            <!-- End General Form Elements -->
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>
