<?php
include("../../auth/authenticationForUser.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="pagetitle">
    <h1>Hello, User!</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="index.html">Home</a></li>
    </ol>
    </nav>
</div><!-- End Page Title -->
   
   
<section class="section">
    <div class="row">
        <!-- Booking Overview (Left Side) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking Overview</h5>
                    
                    <h6>📌 Booking Overview (Current Stay)</h6>
                    <ul>
                        <li><strong>Guest Name:</strong> John Doe</li>
                        <li><strong>Room Type:</strong> Deluxe Suite</li>
                        <li><strong>Room Number:</strong> 305</li>
                        <li><strong>Check-In Date:</strong> March 9, 2025</li>
                        <li><strong>Check-Out Date:</strong></li>
                        <li><strong>Nights Stayed:</strong> 5 Nights</li>
                        <li><strong>Total Amount Paid:</strong> ₱30,500</li>
                        <li><strong>Remaining Balance (if any):</strong> ₱0</li>
                    </ul>

                    <h6>🛎️ Room Services Availed</h6>
                    <ul>
                        <li><strong>Daily Housekeeping:</strong> ✅ Scheduled at 10 AM</li>
                        <li><strong>Laundry Service:</strong> ✅ In Progress</li>
                        <li><strong>Mini-Bar Charges:</strong> ₱750</li>
                    </ul>

                    <h6>🏨 Hotel Facilities & Perks</h6>
                    <ul>
                        <li><strong>Breakfast Included:</strong> ✅ Served from 6 AM - 10 AM</li>
                        <li><strong>Pool & Gym Access:</strong> ✅ 24/7 Available</li>
                        <li><strong>Wi-Fi Status:</strong> ✅ Connected</li>
                    </ul>
                </div>
            </div>
        </div><!-- End Booking Overview -->

        <!-- Booking History (Right Side) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking History</h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Room Type</th>
                                <th scope="col">Check-In Date</th>
                                <th scope="col">Check-Out Date</th>
                                <th scope="col">Room Services</th>
                                <th scope="col">Total Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Deluxe Suite</td>
                                <td>2025-02-15</td>
                                <td>2025-02-18</td>
                                <td>Breakfast, Laundry</td>
                                <td>₱30,500</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Standard Room</td>
                                <td>2025-03-01</td>
                                <td>2025-03-05</td>
                                <td>Room Cleaning</td>
                                <td>₱18,000</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Executive Room</td>
                                <td>2025-01-20</td>
                                <td>2025-01-25</td>
                                <td>Breakfast, Spa</td>
                                <td>₱42,000</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Family Room</td>
                                <td>2025-02-10</td>
                                <td>2025-02-14</td>
                                <td>Extra Bed, Laundry</td>
                                <td>₱28,500</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Standard Room</td>
                                <td>2025-02-22</td>
                                <td>2025-02-28</td>
                                <td>None</td>
                                <td>₱10,000</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Standard Room</td>
                                <td>2025-03-05</td>
                                <td>2025-03-08</td>
                                <td>Room Cleaning</td>
                                <td>₱17,500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Booking History -->
    </div> <!-- End Row -->

    <!-- Booking FAQs (Below) -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Frequently Asked Questions</h5>

                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ Items -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What time is check-in and check-out?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>Check-in:</strong> 2:00 PM onwards<br>
                                    <strong>Check-out:</strong> Until 12:00 PM<br>
                                    Late check-out may be available upon request and subject to additional charges.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can I modify or cancel my booking?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can modify or cancel your booking by contacting our front desk or using the online booking system. Cancellation fees may apply based on the booking policy.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What amenities are included in my stay?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Your stay includes free Wi-Fi, breakfast, pool & gym access, and daily housekeeping. Additional services like laundry and spa treatments are available at an extra charge.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- End Booking FAQs -->
    </div> <!-- End Row -->

</section>




<?php
include("./includes/footer.php");
?>