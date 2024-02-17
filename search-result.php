<?php

session_start();
include 'config/dbcon.php';

$search = '';
if(isset($_GET['search'])){
  $search = $_GET['search'];
}

$query = "SELECT s.id, s.profession_name, s.image  
          FROM service s
          JOIN professional p ON s.professional_id = p.id
          WHERE s.status = 1";

if($search){
  $query .= " AND (p.city LIKE '%$search%' OR p.zipcode LIKE '%$search%')";  
} else {
  // Get subcategory ID from URL parameter
  $subcategory_id = $_GET['id'];

  $query .= " AND s.sub_category_id = $subcategory_id";
}

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
                    <h2 class="breadcrumb__title">Search Result</h2>
                    <div class="breadcrumb__menu">
                        <nav>
                            <ul>
                                <li><span><a href="index.php">Home</a></span></li>
                                <li><span>Search Result</span></li>
                            </ul>
                        </nav>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Slider area start --> 
    <section class="project-page-section section-space p-relative fix">
        <div class="small-container">
            <h5 class="blog-widget-title p-relative mb-45">Search Result</h5>
            <div class="row g-4">
                <?php
                    // Check if query execution is successful 
                    if($result){

                        // Check if any subcategories are available
                        if(mysqli_num_rows($result) > 0){
                        
                        // Output each subcategory
                        while($row = mysqli_fetch_assoc($result)){
                        
                            // Check if 'id' key exists
                            if(array_key_exists('id', $row)){
                                echo '<div class="col-xxl-4 col-xl-4 col-lg-4 mb-15">';
                                echo '<div class="project-slider-area p-relative">';
                                echo '<figure class="image m-img">';
                                echo '<img src="uploads/service/' . basename($row['image']) . '" alt="' . $row['profession_name'] . '">';
                                echo '</figure>';
                                echo '<div class="content-area">';
                                echo '<div class="title-area">';
                                echo '<h5><a href="service-details.php?id=' . $row['id'] . '">' . $row['profession_name'] . '</a></h5>'; 
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo "Service ID not available.";
                             }
                            
                          }
                          
                       } else {
                          echo "No services available for this sub-category.";
                       }
                       
                    } else {
                       echo "Failed to retrieve services from database.";
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