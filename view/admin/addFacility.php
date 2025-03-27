<?php
include("../../dB/config.php"); // Include database connection
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Handle form submission for adding a facility
if (isset($_POST['submit'])) {
    $facility_name = $_POST['facility_name'];
    $description = $_POST['description'];

    // Check for empty values (just in case)
    if (!empty($facility_name) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO facilities (facility_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $facility_name, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Facility added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding facility.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill out all fields.');</script>";
    }
}

$conn->close();
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Facility</h5>

            <!-- General Form Elements -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <label for="facility_name" class="col-sm-2 col-form-label">Facility Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="facility_name" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Submit</label>
                    <div class="col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary">Submit Form</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
