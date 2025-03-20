<?php
include("../../dB/config.php");
include("../../auth/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Fetch total rooms
$query_total_rooms = "SELECT COUNT(*) AS total_rooms FROM rooms";
$result_total_rooms = mysqli_query($conn, $query_total_rooms);
$row_total_rooms = mysqli_fetch_assoc($result_total_rooms);
$total_rooms = $row_total_rooms['total_rooms'];

// Fetch available rooms (rooms with status 'Open')
$query_available_rooms = "SELECT COUNT(*) AS available_rooms FROM rooms WHERE status = 'Available'";
$result_available_rooms = mysqli_query($conn, $query_available_rooms);
$row_available_rooms = mysqli_fetch_assoc($result_available_rooms);
$available_rooms = $row_available_rooms['available_rooms'];


// Fetch total check-ins
$query_check_ins = "
    SELECT COUNT(*) AS total_check_ins 
    FROM reservations 
    WHERE reservation_status = 'Checked In'";

$result_check_ins = mysqli_query($conn, $query_check_ins);
$row_check_ins = mysqli_fetch_assoc($result_check_ins);
$total_check_ins = $row_check_ins['total_check_ins'];

// Fetch total check-outs
$query_check_outs = "
    SELECT COUNT(*) AS total_check_outs 
    FROM reservations 
    WHERE reservation_status = 'Checked Out'";

$result_check_outs = mysqli_query($conn, $query_check_outs);
$row_check_outs = mysqli_fetch_assoc($result_check_outs);
$total_check_outs = $row_check_outs['total_check_outs'];

// Fetch room availability counts
$query = "
    SELECT 
    SUM(CASE WHEN status = 'Occupied' THEN 1 ELSE 0 END) AS occupied,
    SUM(CASE WHEN status = 'Available' THEN 1 ELSE 0 END) AS available,
    SUM(CASE WHEN status = 'Not ready' THEN 1 ELSE 0 END) AS not_ready,
    (SELECT COUNT(*) FROM reservations WHERE reservation_status = 'Booked') AS reserved
FROM rooms";

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    $occupied = $row['occupied'] ?? 0;
    $available = $row['available'] ?? 0;
    $not_ready = $row['not_ready'] ?? 0;
    $reserved = $row['reserved'] ?? 0;
} else {
    echo "Query Error: " . mysqli_error($conn);
}

// Compute total rooms
$total_rooms = $occupied + $available + $not_ready + $reserved;

// Compute total rooms
$total_rooms = $occupied + $available + $not_ready + $reserved;

// Prevent division by zero
if ($total_rooms == 0) {
    $occupied_percentage = 0;
    $reserved_percentage = 0;
    $available_percentage = 0;
    $not_ready_percentage = 0;
} else {
    $occupied_percentage = ($occupied / $total_rooms) * 100;
    $reserved_percentage = ($reserved / $total_rooms) * 100;
    $available_percentage = ($available / $total_rooms) * 100;
    $not_ready_percentage = ($not_ready / $total_rooms) * 100;
}

// Fetch daily reservation counts
$query = "
    SELECT 
        DATE(created_at) AS date,
        SUM(CASE WHEN reservation_status = 'Booked' THEN 1 ELSE 0 END) AS booked,
        SUM(CASE WHEN reservation_status = 'Cancelled' THEN 1 ELSE 0 END) AS canceled
    FROM reservations
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)  -- Get data for the last 7 days
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at) ASC";

$result = mysqli_query($conn, $query);

$dates = [];
$bookedData = [];
$canceledData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = date("d M", strtotime($row['date']));  // Format as "01 Jan"
    $bookedData[] = $row['booked'];
    $canceledData[] = $row['canceled'];
}



?>

    <div class="pagetitle">
      <h1>Welcome back!</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                  <h5 class="card-title">Available Room <span>| today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi-door-open"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $available_rooms; ?></h6>
                      <span class="text-muted small pt-2 ps-1">available rooms</span>

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
                  <h5 class="card-title">Checkins <span>| current</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_check_ins; ?></h6>
                      <span class="text-muted small pt-2 ps-1">guests</span>

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
                  <h5 class="card-title">Checkouts <span>| current</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_check_outs; ?></h6>
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
                <div class="progress-bar" style="width: <?php echo $reserved_percentage; ?>%; background-color: #FBC9A6;" title="Reserved"></div>
                <div class="progress-bar" style="width: <?php echo $available_percentage; ?>%; background-color: #FDE7DA;" title="Available"></div>
                <div class="progress-bar" style="width: <?php echo $not_ready_percentage; ?>%; background-color: #DFF5E1;" title="Not Ready"></div>
            </div>

            <!-- Room Status Summary -->
            <div class="row text-center mt-4">
                <div class="col-6">
                <span style="color: #F8A87D; border-left: 4px solid #F8A87D; padding-left: 5px;">Occupied</span>
                <h4><?php echo $occupied; ?></h4>
                </div>
                <div class="col-6">
                <span style="color: #FBC9A6; border-left: 4px solid #FBC9A6; padding-left: 5px;">Reserved</span>
                <h4><?php echo $reserved; ?></h4>
                </div>
                <div class="col-6 mt-3">
                <span style="color: #FDE7DA; border-left: 4px solid #FDE7DA; padding-left: 5px;">Available</span>
                <h4><?php echo $available; ?></h4>
                </div>
                <div class="col-6 mt-3">
                <span style="color: #DFF5E1; border-left: 4px solid #DFF5E1; padding-left: 5px;">Not Ready</span>
                <h4><?php echo $not_ready; ?></h4>
                </div>
            </div>

            </div>
        </div>
        </div>


        <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Reservation</h5>

            <!-- Bar Chart -->
            <div id="reservationChart"></div>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#reservationChart"), {
                    series: [
                    {
                        name: "Booked",
                        data: <?php echo json_encode($bookedData); ?>
                    },
                    {
                        name: "Canceled",
                        data: <?php echo json_encode($canceledData); ?>
                    }
                    ],
                    chart: {
                    type: "bar",
                    height: 175,
                    stacked: true, // Stacked bars
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
                    colors: ["#6a4c93", "#f4a261"], // Purple for Booked, Yellow for Canceled
                    xaxis: {
                    categories: 
                      <?php echo json_encode($dates); ?>
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