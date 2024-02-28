<?php
session_start();

// Check if the user is a professional
if (!isset($_SESSION['user_data']) || $_SESSION['user_type'] !== 'professional') {
    // Redirect to a different page or display an error message
    header("Location: signin.php");
    exit();
}

include 'config/dbcon.php';

// Retrieve order data related to the signed-in professional's ID
$professional_id = $_SESSION['user_data']['id'];
$orderQuery = "SELECT o.*, c.fname AS customer_fname, c.lname AS customer_lname, s.price, s.profession_name AS service_name
               FROM `order` o
               INNER JOIN `service` s ON o.service_id = s.id
               INNER JOIN `customer` c ON o.customer_id = c.id
               WHERE s.professional_id = $professional_id";
$orderResult = mysqli_query($con, $orderQuery);


?>

<?php include('partials/header.php'); ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

    .custom-table thead th {
        font-family: "Roboto", sans-serif;
        font-size: 18px;
        background-color: #102039;
        color: #ffffff; 
        height: 50px;
    }
</style>

<main>
   
 <!-- Breadcrumb area start --> 
<div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
   <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
   <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative">
               <h2 class="breadcrumb__title">Orders</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="account.php">Account</a></span></li>
                        <li><span>Orders</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
 <!-- Breadcrumb area end -->

 <section class="contact-page-section section-space">
    <div class="small-container">
        <div class="row justify-content-center">
            <div class="col-xxl-12">
                <div class="contact-page-form-area">
                    <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                        <span class="section-sub-title">Order Details</span>
                        <h3 class="section-title mt-10">My Orders</h3>
                    </div>
                    <div class="contact-page-form">
                        <div class="table-responsive" style="border-radius: 8px; max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered custom-table">
                                <thead>
                                    <tr class='align-middle'>
                                        <th class='text-center' style="width: 5%;">ID</th>
                                        <th style="width: 15%;">Customer's Name</th>
                                        <th style="width: 30%;">Description</th>
                                        <th style="width: 10%;">Date & Time</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through the fetched order data and display it in the table
                                    while ($row = mysqli_fetch_assoc($orderResult)) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>{$row['id']}</td>";
                                        echo "<td>{$row['customer_fname']} {$row['customer_lname']}</td>";
                                        echo "<td>{$row['description']}</td>"; 
                                        echo "<td>{$row['date']} {$row['time']}</td>"; 
                                        echo "<td></td>";
                                        echo "<td></td>"; 
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
 </section>
 
</main>


<!-- Footer area start -->
<?php include('partials/footer.php'); ?>