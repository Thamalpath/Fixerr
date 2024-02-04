<?php
session_start();
include 'config/dbcon.php';

// Retrieve categories from the database
$query_categories = "SELECT `id`, `cat_name` FROM `category` WHERE `status` = 1";
$result_categories = mysqli_query($con, $query_categories);

// Retrieve subcategories from the database
$query_subcategories = "SELECT `id`, `sub_cat_name`, `category_id` FROM `sub_category` WHERE `status` = 1";
$result_subcategories = mysqli_query($con, $query_subcategories);

mysqli_close($con);
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
               <h2 class="breadcrumb__title">Add Service</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="account-pro.php">Account</a></span></li>
                        <li><span>Add Service</span></li>
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
                  <span class="section-sub-title">Add Service</span>
                  <h3 class="section-title mt-10">Please Provide the Data for Your Service</h3>
               </div>
               <div class="contact-page-form">
                    <form method="post" id="staffForm" class="account-form">
                        <div class="row mb-10-none mt-20">
                            <div class="col-lg-12">
                                <label>Profession Name</label>
                                <input type="text" placeholder="Profession Name" name="profession_name" required>
                            </div>
                            <div class="col-lg-12 mb-40">
                                <label>Description</label>
                                <textarea name="description" id="description" placeholder="Description" required spellcheck="true"></textarea>
                            </div>
                            <div class="col-lg-12 mb-40">
                                <label>Image</label>
                                <input class="form-control" type="file" id="image" name="image" required onchange="previewImage()">
                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto;">
                            </div>
                            <div class="col-lg-6">
                                <label>Category</label>
                                <div class="contact__select mb-20">
                                    <select id="category" name="category" onchange="populateSubcategories()">
                                        <option value="0">Select Category</option>
                                        <?php while ($row_category = mysqli_fetch_assoc($result_categories)): ?>
                                            <option value="<?php echo $row_category['id']; ?>"><?php echo $row_category['cat_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Sub Category</label>
                                <div class="contact__select mb-20">
                                    <select id="subcategory" name="subcategory">
                                        <option value="0">Select Sub-Category</option>
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
        <?php while ($row_subcategory = mysqli_fetch_assoc($result_subcategories)): ?>
            if (<?php echo $row_subcategory['category_id']; ?> == categoryId) {
                var option = document.createElement('option');
                option.value = <?php echo $row_subcategory['id']; ?>;
                option.text = "<?php echo $row_subcategory['sub_cat_name']; ?>";
                subcategorySelect.appendChild(option);
            }
        <?php endwhile; ?>
    }
</script>