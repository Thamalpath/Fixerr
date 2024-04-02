<?php
session_start();

// Check if the user is a professional
if (!isset($_SESSION['user_data']) || $_SESSION['user_type'] !== 'professional') {
    // Redirect to a different page or display an error message
    header("Location: signin.php");
    exit();
}

include 'config/dbcon.php';

// Retrieve services related to the professional with category and subcategory names from the database
$professional_id = $_SESSION['user_data']['id'];
$query_services = "SELECT s.`id`, s.`profession_name`, s.`description`, s.`image`, s.`price`, s.`status`, c.`cat_name`, sc.`sub_cat_name`
                    FROM `service` s
                    LEFT JOIN `category` c ON s.`category_id` = c.`id`
                    LEFT JOIN `sub_category` sc ON s.`sub_category_id` = sc.`id`
                    WHERE s.`professional_id` = $professional_id";
$result_services = mysqli_query($con, $query_services);

?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Berlin+Sans+FB:wght@300;400;500;600;700;800&display=swap");

    .custom-table thead th {
        font-family: 'Berlin Sans FB', sans-serif;
        font-size: 18px;
        background-color: #102039;
        color: #ffffff; 
        height: 50px;
    }
</style>

<?php include('partials/header.php'); ?>

<main>
   
 <!-- Breadcrumb area start --> 
<div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
   <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
   <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative">
               <h2 class="breadcrumb__title">My Services</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="account.php">Account</a></span></li>
                        <li><span>My Services</span></li>
                     </ul>
                  </nav>
               </div>a
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
                  <span class="section-sub-title">Service Details</span>
                  <h3 class="section-title mt-10">My Services</h3>
               </div>
               <div class="contact-page-form">
                  <div class="table-responsive" style="border-radius: 8px; max-height: 500px; overflow-y: auto;">
                     <table class="table table-bordered custom-table">
                        <thead>
                           <tr class='align-middle'>
                              <th class='text-center' style="width: 5%;">ID</th>
                              <th style="width: 10%;">Profession Name</th>
                              <th style="width: 25%;">Description</th>
                              <th style="width: 10%;">Image</th>
                              <th style="width: 8%;">Price</th>
                              <th style="width: 10%;">Category</th>
                              <th style="width: 12%;">Sub-Category</th>
                              <th style="width: 10%;">Status</th>
                              <th style="width: 10%;">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php
                           // Loop through the fetched data and display it in the table
                           while ($row = mysqli_fetch_assoc($result_services)) {
                              echo "<tr>";
                              echo "<td class='text-center'>{$row['id']}</td>";
                              echo "<td>{$row['profession_name']}</td>";
                              echo "<td>" . implode(' ', array_slice(str_word_count($row['description'], 1), 0, 10)) . "...</td>"; 
                              echo "<td><img src='{$row['image']}' style='max-width: 100px; max-height: 100px;' alt='Service Image'></td>";
                              echo "<td class='text-center'>$ {$row['price']}</td>";
                              echo "<td>{$row['cat_name']}</td>"; 
                              echo "<td>{$row['sub_cat_name']}</td>"; 
                              echo "<td class='text-center'>";
                                 if ($row['status'] == 1) {
                                       echo "Approved";
                                 } elseif ($row['status'] == 0) {
                                       echo "Pending";
                                 } 
                              echo "</td>";
                              echo "<td class='text-center'><a href='service-edit.php?id={$row['id']}' class='primary-btn-4 pay-btn btn-hover w-75'>Edit <span style='top: 147.172px; left: 108.5px;'></span> </a></td>"; 
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
 </section>
 
</main>


<!-- Footer area start -->
<?php include('partials/footer.php'); ?>
