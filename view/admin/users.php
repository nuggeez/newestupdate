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
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Facilities Management</li>
        </ol>
      </nav>
</div><!-- End Page Title -->

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Facilities Management</h5>

              <div class="d-flex justify-content-end mb-3">
                <a href="addFacility.php">
                  <button type="button" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
                </a>
              </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Facility Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch facilities data
                    $query = "SELECT facility_id, facility_name, description FROM facilities";
                    
                    $query_run = mysqli_query($conn, $query);

                    if (!$query_run) {
                        die("Query failed: " . mysqli_error($conn));
                    } 
                    
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                    ?> 
                    <tr>
                        <td><?= $row['facility_name']; ?></td> 
                        <td><?= $row['description'] ?? 'No description available'; ?></td>
                        <td>
                          <div class="d-flex gap-2">
                            <a href="editFacility.php?id=<?= $row['facility_id'] ?? ''; ?>" class="btn btn-warning">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="deleteFacility.php?id=<?= $row['facility_id'] ?? ''; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this facility?');">
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
