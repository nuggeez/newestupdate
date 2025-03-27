<?php
include("../../dB/config.php"); // Include database connection
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO rooms (room_number, room_type, capacity, status, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $room_number, $room_type, $capacity, $status, $price);

    // Execute query
    if ($stmt->execute()) {
        echo "<script>alert('Room added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding room.');</script>";
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
            <h5 class="card-title">Add Room</h5>

            <!-- General Form Elements -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <label for="room_number" class="col-sm-2 col-form-label">Room Number</label>
                    <div class="col-sm-10">
                        <input type="number" name="room_number" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-10">
                        <select name="room_type" class="form-select" required>
                            <option selected disabled>Select room type</option>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Suite">Suite</option>
                            <option value="Family">Family</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="capacity" class="col-sm-2 col-form-label">Capacity</label>
                    <div class="col-sm-10">
                        <input type="number" name="capacity" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-select">
                            <option value="Available" selected>Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="price" class="col-sm-2 col-form-label">Price (₱)</label>
                    <div class="col-sm-10">
                        <input type="number" name="price" class="form-control" step="0.01" required>
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
