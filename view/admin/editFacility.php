<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Check if facility ID is set
if (isset($_GET['id'])) {
    $facility_id = $_GET['id'];

    // Fetch facility details from database
    $query = "SELECT * FROM facilities WHERE facility_id = '$facility_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $facility = mysqli_fetch_assoc($query_run);
    } else {
        echo "<script>alert('Facility not found!'); window.location.href='users.php';</script>";
        exit();
    }
}

// Update facility details when form is submitted
if (isset($_POST['update_facility'])) {
    $facility_name = mysqli_real_escape_string($conn, $_POST['facility_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE facilities SET facility_name='$facility_name', description='$description' WHERE facility_id='$facility_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Facility updated successfully!'); window.location.href='facilities.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Facility</h5>

      <!-- Facility Edit Form -->
      <form method="POST">
        <div class="row mb-3">
          <label for="facility_name" class="col-sm-2 col-form-label">Facility Name</label>
          <div class="col-sm-10">
            <input type="text" name="facility_name" class="form-control" value="<?= $facility['facility_name']; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="description" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea name="description" class="form-control" rows="4" required><?= $facility['description']; ?></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" name="update_facility" class="btn btn-primary">Update Facility</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
      <!-- End Facility Edit Form -->

    </div>
  </div>
</div>

<?php include("./includes/footer.php"); ?>
