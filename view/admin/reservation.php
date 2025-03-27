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
            <li class="breadcrumb-item active">Booking Management</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking Management</h5>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Check-In Date</th>
                                <th>Check-Out Date</th>
                                <th>Number of Guests</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Room Number</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT 
                                bookings.booking_id, 
                                CONCAT(users.firstName, ' ', users.lastName) AS full_name, 
                                bookings.guest_id, 
                                bookings.check_in_date, 
                                bookings.check_out_date, 
                                bookings.number_of_guests,
                                users.gender,
                                users.phoneNumber,  
                                users.email, 
                                rooms.room_number, 
                                payments.status AS status
                                FROM 
                                bookings
                                INNER JOIN guests ON bookings.guest_id = guests.guest_id
                                INNER JOIN users ON guests.user_id = users.userId
                                INNER JOIN rooms ON bookings.room_id = rooms.room_id
                                LEFT JOIN payments ON bookings.payment_id = payments.payment_id";                                                                                   
                            
                            $query_run = mysqli_query($conn, $query);

                            if (!$query_run) {
                                die("Query failed: " . mysqli_error($conn));
                            }

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['full_name']; ?></td>
                                        <td><?= $row['gender']; ?></td>
                                        <td><?= $row['check_in_date']; ?></td>
                                        <td><?= $row['check_out_date']; ?></td>
                                        <td><?= $row['number_of_guests']; ?></td>
                                        <td><?= $row['phoneNumber']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['room_number']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td>
                                            <div class="d-flex gap-2" style="margin-top: 5px;">
                                                <a href="editBooking.php?id=<?= $row['booking_id'] ?? ''; ?>" class="btn btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="deleteBooking.php?id=<?= $row['booking_id'] ?? ''; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this reservation?');">
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
