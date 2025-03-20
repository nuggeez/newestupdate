<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Check if ID is set
if (isset($_GET['id'])) {
    $guest_id = $_GET['id'];

    // Fetch guest details from database
    $query = "SELECT * FROM guests WHERE guest_id = '$guest_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $guest = mysqli_fetch_assoc($query_run);
    } else {
        echo "<script>alert('Guest not found!'); window.location.href='users.php';</script>";
        exit();
    }
}

// Update guest details when form is submitted
if (isset($_POST['update_guest'])) {
    $name = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $update_query = "UPDATE guests SET name='$name', gender='$gender', phone_number='$phone_number', email='$email' WHERE guest_id='$guest_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Guest updated successfully!'); window.location.href='users.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Guest</h5>

      <!-- Guest Edit Form -->
      <form method="POST">
        <div class="row mb-3">
          <label for="guest_name" class="col-sm-2 col-form-label">Guest Name</label>
          <div class="col-sm-10">
            <input type="text" name="guest_name" class="form-control" value="<?= $guest['name']; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="gender" class="col-sm-2 col-form-label">Gender</label>
          <div class="col-sm-10">
            <select name="gender" class="form-select" required>
              <option value="Male" <?= ($guest['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
              <option value="Female" <?= ($guest['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
          <div class="col-sm-10">
            <input type="text" name="phone_number" class="form-control" value="<?= $guest['phone_number']; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="email" class="col-sm-2 col-form-label">Email Address</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control" value="<?= $guest['email']; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" name="update_guest" class="btn btn-primary">Update Guest</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
      <!-- End Guest Edit Form -->

    </div>
  </div>
</div>

<?php include("./includes/footer.php"); ?>
