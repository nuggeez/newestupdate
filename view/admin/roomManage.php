<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>Welcome back!</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Main</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active">Room Management</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Room Management</h5>

                    <div class="d-flex justify-content-end mb-3">
                        <a href="addRoom.php">
                            <button type="button" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
                        </a>
                    </div>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Room No.</th>
                                <th>Room Type</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch room details from the `rooms` table
                            $query = "SELECT room_id, room_number, room_type, capacity, status, price FROM rooms";
                            $query_run = mysqli_query($conn, $query);

                            if (!$query_run) {
                                die("Query failed: " . mysqli_error($conn));
                            }
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['room_number']; ?></td>
                                        <td><?= $row['room_type']; ?></td>
                                        <td><?= $row['capacity']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= number_format($row['price'], 2); ?></td>
                                        <td>
                                            <div class="d-flex gap-2" style="margin-top: 5px;">
                                                <a href="editRoom.php?id=<?= $row['room_id'] ?? ''; ?>" class="btn btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="deleteRoom.php?id=<?= $row['room_id'] ?? ''; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

<?php
include("./includes/footer.php");
?>
