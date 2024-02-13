<?php
session_start();
include 'config/dbcon.php';

// Retrieve available categories from the database
$query = "SELECT `id`, `cat_name`, `image` FROM `category` WHERE `status` = 1";
$result = mysqli_query($con, $query);
?>

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
                  <h2 class="breadcrumb__title">Categories</h2>
                  <div class="breadcrumb__menu">
                     <nav>
                        <ul>
                           <li><span><a href="index.php">Home</a></span></li>
                           <li><span>Categories</span></li>
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Breadcrumb area end --> 

   <!-- Service Slider area start --> 
   <section class="project-page-section section-space p-relative fix">
      <div class="small-container">
         <div class="row g-4">
            <?php
               // Check if query execution is successful
               if ($result) {
                  // Check if any categories are available
                  if(mysqli_num_rows($result) > 0) {
                     // Output each category
                     while($row = mysqli_fetch_assoc($result)) {
                        // Check if 'id' key exists in the $row array
                        if (array_key_exists('id', $row)) {
                              echo '<div class="col-xxl-4 col-xl-4 col-lg-4 mb-15">';
                              echo '<div class="project-slider-area p-relative">';
                              echo '<figure class="image m-img">';
                              echo '<img src="admin/uploads/category/' . basename($row['image']) . '" alt="' . $row['cat_name'] . '">';
                              echo '</figure>';
                              echo '<div class="content-area">';
                              echo '<div class="title-area">';
                              echo '<h5><a href="sub-category.php?category_id=' . $row['id'] . '">' . $row['cat_name'] . '</a></h5>'; 
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                        } else {
                              echo "Category ID is not available for some categories.";
                        }
                     }
                  } else {
                     echo "No categories available.";
                  }
               } else {
                  echo "Failed to retrieve categories from the database.";
               }

               mysqli_close($con);
            ?>
         </div>
      </div>
   </section>
   <!-- Service Slider area end --> 

 </main> 

<!-- Footer area start -->
<?php include('partials/footer.php'); ?>