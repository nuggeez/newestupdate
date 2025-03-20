<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

if (isset($_GET['id'])) {
    $room_id = intval($_GET['id']);

    $query = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $room_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $room = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$room) {
            echo "<script>alert('Room not found!'); window.location.href='roomManage.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error fetching room data!'); window.location.href='roomManage.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='RoomManage.php';</script>";
    exit();
}

// Handle form submission
if (isset($_POST['update_room'])) {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $bed_capacity = $_POST['bed_capacity'];
    $status = $_POST['status'];

    $query = "UPDATE rooms SET room_number=?, room_type=?, bed_capacity=?, status=? WHERE room_id=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisi", $room_number, $room_type, $bed_capacity, $status, $room_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Room updated successfully!'); window.location.href='roomManage.php';</script>";
        } else {
            echo "<script>alert('Error updating room!');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Room</h5>

            <form method="POST">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room Number</label>
                    <div class="col-sm-10">
                        <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($room['room_number']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-10">
                        <input type="text" name="room_type" class="form-control" value="<?= htmlspecialchars($room['room_type']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Bed Capacity</label>
                    <div class="col-sm-10">
                        <input type="number" name="bed_capacity" class="form-control" value="<?= htmlspecialchars($room['bed_capacity']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-select" required>
                            <option value="Available" <?= ($room['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                            <option value="Occupied" <?= ($room['status'] == 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                            <option value="Reserved" <?= ($room['status'] == 'Reserved') ? 'selected' : ''; ?>>Reserved</option>
                            <option value="Not ready" <?= ($room['status'] == 'Not ready') ? 'selected' : ''; ?>>Not ready</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update_room" class="btn btn-primary">Update Room</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
