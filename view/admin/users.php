<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>


<div class="pagetitle">
      <h1>Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Users</h5>

              <div class="d-flex justify-content-end mb-3">
                <a href="addUser.php">
                  <button type="button" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
                </a>
              </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      Full Name
                    </th>
                    <th>Full Name</th>
                    <th>Mobile number</th>
                    <th>Gender</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Birthday</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT  `firstName`,`lastName`,`phoneNumber`,`gender`,`birthday` FROM `users` ";
                    $query_run = mysqli_query($con, $query);

                    if (!$query_run) {
                        die("Query failed: " .mysql_error($con));
                    } 
                    if (mysqli_num_rows($query_run) > 0) 
                    {
                        foreach($query_run as $row) {
                    ?> 
                    <tr>
                        <td><?= $row['firstName']; ?> <?= $row['lastName']; ?></td>
                        <td><?= $row['phoneNumber']; ?></td>
                        <td><?= $row['gender']; ?></td>
                        <td><?= $row['birthday']; ?></td>
                        <td><button class="btn btn-primary"><i class="bi bi-eye"></i></button></td>
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