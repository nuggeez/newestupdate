  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="bookAroom.php">
          <i class="bi bi-door-open"></i>
          <span>Book A Room</span>
        </a>
      </li><!-- End Booking Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="roomServices.php">
          <i class="bi bi-bell"></i>
          <span>Room Services</span>
        </a>
      </li><!-- End Room Services Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#hotelacts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i><span>Hotel Activities</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="hotelacts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="facilities.php">
              <i class="bi bi-circle"></i><span>Facility Reservations</span>
            </a>
          </li>
        </ul> 
      </li><!-- End Hotel Activities Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <style>
  body {
    background-color: #F4F7EF;
  }
  /* Set font color */
  body, h1, h2, h3, h4, h5, h6, p, label, .form-label {
      color: #1e1e1e !important;
  }

  /* Change active text color */
  a, a:hover, a:focus {
      color: #BB9C34 !important;
  }

  /* Change button color */
  .btn-primary {
      background-color: #FBC741 !important;
      border-color: #FBC741 !important;
      color: #1e1e1e !important;
  }

  /* Button hover effect */
  .btn-primary:hover {
      background-color: #e0a830 !important;
      border-color: #e0a830 !important;
  }

  /* Change sidebar icon color */
  .sidebar-nav i {
      color: #BB9C34 !important;
  }
</style>



  <main id="main" class="main">