<?php
session_start();

// Check if the user is a professional
if (!isset($_SESSION['user_data']) || $_SESSION['user_type'] !== 'professional') {
    // Redirect to a different page or display an error message
    header("Location: signin.php");
    exit();
}

include 'config/dbcon.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $profession_name = mysqli_real_escape_string($con, $_POST['profession_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = $_POST['category'];
    $sub_category_id = $_POST['subcategory'];
    $service_id = $_POST['service_id']; // Added to get the service ID from the form

    // Check if an image is uploaded
    if ($_FILES['image']['name'] != "") {
        // Image handling
        $image = $_FILES['image']['name']; 
        $image_tmp = $_FILES['image']['tmp_name']; 
        
        // Perform validation for image type
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
            $_SESSION['error'] = "Only JPG and JPEG files are allowed.";
            header("Location: service-edit.php?id={$service_id}"); // Redirect to form page with the service ID
            exit();
        }
        
        // Move the uploaded image to the desired directory
        $upload_path = "uploads/service/" . $image;
        if (move_uploaded_file($image_tmp, $upload_path)) {
            // Delete the previous image from the server
            $query_delete_image = "SELECT `image` FROM `service` WHERE `id` = $service_id";
            $result_delete_image = mysqli_query($con, $query_delete_image);
            $row_delete_image = mysqli_fetch_assoc($result_delete_image);
            $previous_image_path = $row_delete_image['image'];
            unlink($previous_image_path); // Delete the previous image file
            
            // Update the image path in the database
            $query_update_image = "UPDATE `service` SET `image` = '$upload_path' WHERE `id` = $service_id";
            mysqli_query($con, $query_update_image);
        } else {
            $_SESSION['error'] = "Failed to upload image. Please try again.";
            header("Location: service-edit.php?id={$service_id}"); // Redirect to form page with the service ID
            exit();
        }
    }

    // Update other service data in the database
    $query_update_service = "UPDATE `service` SET `profession_name` = '$profession_name', `description` = '$description', `category_id` = '$category_id', `sub_category_id` = '$sub_category_id' WHERE `id` = $service_id";
    $result_update_service = mysqli_query($con, $query_update_service);

    if ($result_update_service) {
        $_SESSION['success'] = "Service updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update service. Please try again.";
    }
    
    // Redirect to the service details page
    header("Location: pro-services.php");
    exit();
}

// If the form is not submitted, retrieve service details for editing
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    
    // Retrieve service details from the database
    $query_service = "SELECT `id`, `profession_name`, `description`, `image`, `category_id`, `sub_category_id` FROM `service` WHERE `id` = $service_id";
    $result_service = mysqli_query($con, $query_service);
    $row_service = mysqli_fetch_assoc($result_service);
} else {
    // If no service ID is provided, redirect to pro-services.php
    header("Location: pro-services.php");
    exit();
}

// Retrieve categories from the database
$query_categories = "SELECT `id`, `cat_name` FROM `category` WHERE `status` = 1";
$result_categories = mysqli_query($con, $query_categories);

// Retrieve subcategories from the database
$query_subcategories = "SELECT `id`, `sub_cat_name`, `category_id` FROM `sub_category` WHERE `status` = 1";
$result_subcategories = mysqli_query($con, $query_subcategories);

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
               <h2 class="breadcrumb__title">Edit Service</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="pro-services.php">Services</a></span></li>
                        <li><span>Edit Service</span></li>
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
         <div class="col-xxl-8 col-xl-8 col-lg-8 mx-auto"> 
            <div class="contact-page-form-area">
               <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                  <span class="section-sub-title">Edit Service</span>
                  <h3 class="section-title mt-10">Edit Your Service</h3>
               </div>
               <div class="contact-page-form">
                    <form method="post" id="serviceForm" class="account-form" enctype="multipart/form-data">
                        <input type="hidden" name="service_id" value="<?php echo $row_service['id']; ?>">
                        <div class="row mb-10-none mt-20">
                            <div class="col-lg-12">
                                <label>Profession Name</label>
                                <input type="text" placeholder="Profession Name" name="profession_name" value="<?php echo $row_service['profession_name']; ?>" required>
                            </div>
                            <div class="col-lg-12 mb-40">
                                <label>Description</label>
                                <textarea name="description" id="description" placeholder="Description" required><?php echo $row_service['description']; ?></textarea>
                            </div>
                            <div class="col-lg-12 mb-40">
                                <label>Image</label>
                                <input class="form-control" type="file" id="image" name="image" onchange="previewImage()">
                                <img id="imagePreview" src="<?php echo $row_service['image']; ?>" alt="Current Image Preview" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="col-lg-6">
                                <label>Category</label>
                                <div class="contact__select mb-20">
                                    <select id="category" name="category" onchange="populateSubcategories()">
                                        <option value="0">Select Category</option>
                                        <?php while ($row_category = mysqli_fetch_assoc($result_categories)): ?>
                                            <option value="<?php echo $row_category['id']; ?>" <?php if ($row_category['id'] == $row_service['category_id']) echo "selected"; ?>><?php echo $row_category['cat_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Sub Category</label>
                                <div class="contact__select mb-20">
                                    <select id="subcategory" name="subcategory">
                                        <option value="0">Select Sub-Category</option>
                                        <?php while ($row_subcategory = mysqli_fetch_assoc($result_subcategories)): ?>
                                            <option value="<?php echo $row_subcategory['id']; ?>" <?php if ($row_subcategory['id'] == $row_service['sub_category_id']) echo "selected"; ?>><?php echo $row_subcategory['sub_cat_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 form-group text-center mt-10">
                                <button  type="submit" class="primary-btn-1 btn-hover w-100">
                                    Submit &nbsp; | <i class="icon-right-arrow"></i>
                                    <span style="top: 147.172px; left: 108.5px;"></span>
                                </button>
                            </div>
                        </div>
                    </form>
               </div>
            </div>
         </div>
      </div>
   </div>
 </section>

</main>

<!-- Footer area start -->
<?php include('partials/footer.php'); ?>

<script>
    function previewImage() {
        var fileInput = document.getElementById('image');
        var imagePreview = document.getElementById('imagePreview');
        
        // Check if any file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // Set the source of the image preview to the data URL
                imagePreview.src = e.target.result;
                // Display the image preview
                imagePreview.style.display = 'block';
            }
            
            // Read the image file as a data URL
            reader.readAsDataURL(fileInput.files[0]);
        }
    }


    function populateSubcategories() {
        var categoryId = document.getElementById('category').value;
        var subcategorySelect = document.getElementById('subcategory');

        // Clear existing options
        subcategorySelect.innerHTML = '<option value="0">Select Sub-Category</option>';

        // Retrieve subcategories related to the selected category
        <?php mysqli_data_seek($result_subcategories, 0); // Reset pointer to the beginning of result set ?>
        <?php while ($row_subcategory = mysqli_fetch_assoc($result_subcategories)): ?>
            if (<?php echo $row_subcategory['category_id']; ?> == categoryId) {
                var option = document.createElement('option');
                option.value = <?php echo $row_subcategory['id']; ?>;
                option.text = "<?php echo $row_subcategory['sub_cat_name']; ?>";
                <?php if ($row_subcategory['id'] == $row_service['sub_category_id']): ?>
                    option.selected = true;
                <?php endif; ?>
                subcategorySelect.appendChild(option);
            }
        <?php endwhile; ?>
    }
</script>
