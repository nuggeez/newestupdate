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
          <li class="breadcrumb-item active">Reservation Management</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reservation Management</h5>

              <div class="d-flex justify-content-end mb-3">
                <a href="addBooking.php">
                  <button type="button" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
                </a>
              </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      Guest Name
                    </th>
                    <th>Gender</th>
                    <th>Check in</th>
                    <th>Check out</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Payment</th>
                    <th>Reservation Status</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT reservations.reservation_id, guests.name AS guest_name, guests.gender, reservations.check_in, reservations.check_out, guests.phone_number, guests.email, rooms.room_number, rooms.room_type, reservations.payment_status, reservations.reservation_status FROM reservations INNER JOIN guests ON reservations.guest_id = guests.guest_id INNER JOIN rooms ON reservations.room_id = rooms.room_id";  
                    $query_run = mysqli_query($conn, $query);

                    if (!$query_run) {
                        die("Query failed: " .mysqli_error($conn));
                    } 
                    if (mysqli_num_rows($query_run) > 0) 
                    {
                        foreach($query_run as $row) {
                    ?> 
                    <tr>
                        <td><?= $row['guest_name']; ?></td>
                        <td><?= $row['gender']; ?></td>
                        <td><?= $row['check_in']; ?></td>
                        <td><?= $row['check_out']; ?></td>
                        <td><?= $row['phone_number']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['room_number']; ?></td>
                        <td><?= $row['room_type']; ?></td>
                        <td><?= $row['payment_status']; ?></td>
                        <td><?= $row['reservation_status']; ?></td>
                        <td>
                          <div class="d-flex gap-2" style="margin-top: 5px;">
                            <a href="editReservation.php?id=<?= $row['reservation_id'] ?? ''; ?>" class="btn btn-warning">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="deleteReservation.php?id=<?= $row['reservation_id'] ?? ''; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">
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