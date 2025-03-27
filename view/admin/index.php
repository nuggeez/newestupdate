<?php
include("../../dB/config.php");
include("../../auth/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");


// Fetch total bookings from the 'bookings' table
$query_total_bookings = "SELECT COUNT(*) AS total_bookings FROM bookings";
$result_total_bookings = mysqli_query($conn, $query_total_bookings);

if ($result_total_bookings) {
    $row = mysqli_fetch_assoc($result_total_bookings);
    $total_bookings = $row['total_bookings'] ?? 0;  // Default to 0 if NULL
} else {
    echo "Query Error: " . mysqli_error($conn);
}


// SQL query to fetch total pending payments
$query_pending_payments = "SELECT COUNT(*) AS total_pending_payments FROM payments WHERE status = 'Pending'";
$result_pending_payments = mysqli_query($conn, $query_pending_payments);

if ($result_pending_payments) {
    $row = mysqli_fetch_assoc($result_pending_payments);
    $total_pending_payments = $row['total_pending_payments'] ?? 0;  // Default to 0 if NULL
} else {
    echo "Query Error: " . mysqli_error($conn);
}


// SQL query to count total guests (users only, not admins)
$query_total_guests = "SELECT COUNT(*) AS total_guests FROM users WHERE role = 'user'";
$result_total_guests = mysqli_query($conn, $query_total_guests);

if ($result_total_guests) {
    $row = mysqli_fetch_assoc($result_total_guests);
    $total_guests = $row['total_guests'] ?? 0;  // Default to 0 if no guests are found
} else {
    echo "Query Error: " . mysqli_error($conn);
}


// Fetch room availability counts
$query = "
    SELECT 
        SUM(CASE WHEN status = 'Occupied' THEN 1 ELSE 0 END) AS occupied,
        SUM(CASE WHEN status = 'Available' THEN 1 ELSE 0 END) AS available,
        SUM(CASE WHEN status = 'Maintenance' THEN 1 ELSE 0 END) AS maintenance
    FROM rooms";

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    $occupied = $row['occupied'] ?? 0;
    $available = $row['available'] ?? 0;
    $maintenance = $row['maintenance'] ?? 0;
} else {
    echo "Query Error: " . mysqli_error($conn);
}

// Compute total rooms
$total_rooms = $occupied + $available + $maintenance;

// Prevent division by zero
if ($total_rooms == 0) {
    $occupied_percentage = 0;
    $available_percentage = 0;
    $maintenance_percentage = 0;
} else {
    $occupied_percentage = ($occupied / $total_rooms) * 100;
    $available_percentage = ($available / $total_rooms) * 100;
    $maintenance_percentage = ($maintenance / $total_rooms) * 100;
}

// Fetch total check ins and out
$query = "
    SELECT 
        DATE(check_in_date) AS date,
        SUM(CASE WHEN check_in_date IS NOT NULL THEN 1 ELSE 0 END) AS check_in_count,
        SUM(CASE WHEN check_out_date IS NOT NULL THEN 1 ELSE 0 END) AS check_out_count
    FROM bookings
    WHERE check_in_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) -- Last 7 days of check-in data
    GROUP BY DATE(check_in_date)
    ORDER BY DATE(check_in_date) ASC";

$result = mysqli_query($conn, $query);

$dates = [];
$checkInData = [];
$checkOutData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = date("d M", strtotime($row['date'])); // Format date as "01 Jan"
    $checkInData[] = $row['check_in_count'];
    $checkOutData[] = $row['check_out_count'];
}




?>

    <div class="pagetitle">
      <h1>Welcome back!</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-15">
          <div class="row">

            <!-- Room availability Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total Bookings <span>| today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi-door-open"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_bookings; ?></h6>
                      <span class="text-muted small pt-2 ps-1">total bookings</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Room availability Card -->

            <!-- Checkins Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">pending payments <span>| current</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_pending_payments; ?></h6>
                      <span class="text-muted small pt-2 ps-1">pendings</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End checkins Card -->

            <!-- Checkouts Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">total guests <span>| current</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_guests; ?></h6>
                      <span class="text-muted small pt-2 ps-1">guests</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End checkouts Card -->

            
            <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Room Availability</h5>

            <!-- Room Availability Progress Bar -->
            <div class="progress mt-3" style="height: 20px; border-radius: 10px;">
                <div class="progress-bar" style="width: <?php echo $occupied_percentage; ?>%; background-color: #F8A87D;" title="Occupied"></div>
                <div class="progress-bar" style="width: <?php echo $maintenance_percentage; ?>%; background-color: #FBC9A6;" title="Maintenance"></div>
                <div class="progress-bar" style="width: <?php echo $available_percentage; ?>%; background-color: #FDE7DA;" title="Available"></div>
            </div>

            <!-- Room Status Summary -->
            <div class="row text-center mt-4">
                <div class="col-4">
                    <span style="color: #F8A87D; border-left: 4px solid #F8A87D; padding-left: 5px;">Occupied</span>
                    <h4><?php echo $occupied; ?></h4>
                </div>
                <div class="col-4">
                    <span style="color: #FBC9A6; border-left: 4px solid #FBC9A6; padding-left: 5px;">Maintenance</span>
                    <h4><?php echo $maintenance; ?></h4>
                </div>
                <div class="col-4">
                    <span style="color: #FDE7DA; border-left: 4px solid #FDE7DA; padding-left: 5px;">Available</span>
                    <h4><?php echo $available; ?></h4>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Total Check-Ins and Check-Outs</h5>

            <!-- Bar Chart -->
            <div id="checkInOutChart"></div>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#checkInOutChart"), {
                        series: [
                            {
                                name: "Check-Ins",
                                data: <?php echo json_encode($checkInData); ?>
                            },
                            {
                                name: "Check-Outs",
                                data: <?php echo json_encode($checkOutData); ?>
                            }
                        ],
                        chart: {
                            type: "bar",
                            height: 175,
                            stacked: true, // Stacked bars for better comparison
                            toolbar: { show: false },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "40%",
                                borderRadius: 4,
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            style: { colors: ["#fff"] } // White text for readability
                        },
                        colors: ["#1f77b4", "#ff7f0e"], // Blue for Check-Ins, Orange for Check-Outs
                        xaxis: {
                            categories: <?php echo json_encode($dates); ?>
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right"
                        }
                    }).render();
                });
            </script>
            <!-- End Bar Chart -->
        </div>
    </div>
</div>


 
      </div>
    </section>

  </main><!-- End #main -->



<?php
include("./includes/footer.php");
?>