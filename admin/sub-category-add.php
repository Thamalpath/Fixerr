<!-- Notyf -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<?php
session_start();
include '../config/dbcon.php';

// Fetch categories from the database
$category_query = "SELECT `id`, `cat_name` FROM `category` WHERE `status` = 1";
$category_result = mysqli_query($con, $category_query);

// Array to store category options
$category_options = array();

if (mysqli_num_rows($category_result) > 0) {
    while ($row = mysqli_fetch_assoc($category_result)) {
        // Store category options in the array
        $category_options[$row['id']] = $row['cat_name'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sub_cat_name = $_POST['sub_cat_name'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];
    
    // Convert status to 1 for "available" and 0 for "unavailable"
    $status_value = ($status == "available") ? 1 : 0;
    
    // Image handling
    $image = $_FILES['image']['name']; 
    $image_tmp = $_FILES['image']['tmp_name']; 
    
    // Perform validation
    if (!empty($sub_cat_name) && !empty($status) && !empty($image)) {
        // Check if the uploaded file is an image
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
            $_SESSION['error'] = "Only JPG, JPEG files are allowed.";
        } else {
            // Move the uploaded image to the desired directory
            $upload_path = "uploads/sub_category/" . $image;
            if (move_uploaded_file($image_tmp, $upload_path)) {
                // Insert data into database
                $query = "INSERT INTO sub_category (sub_cat_name, image, status, category_id) 
                          VALUES ('$sub_cat_name', '$upload_path', '$status_value', '$category_id')";
                $result = mysqli_query($con, $query);
                if ($result) {
                    $_SESSION['success'] = "Sub-category added successfully.";
                } else {
                    $_SESSION['error'] = "Failed to add sub-category. Please try again.";
                }
            } else {
                $_SESSION['error'] = "Failed to upload image. Please try again.";
            }
        }
    } else {
        $_SESSION['error'] = "All fields are required.";
    }
}

mysqli_close($con);
?>


<?php include('partials/header.php'); ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('partials/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include('partials/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Sub Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Sub Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary m-3">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">Add Sub Category</h3>
              </div>

              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="sub_cat_name">Sub Category Name</label>
                                <input type="text" class="form-control" id="sub_cat_name" name="sub_cat_name">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php
                                    // Populate category options
                                    foreach ($category_options as $id => $name) {
                                        echo "<option value=\"$id\">$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                  <option value="available">Available</option>
                                  <option value="unavailable">Unavailable</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input class="form-control" type="file" id="image" name="image"
                                    onchange="previewImage()">
                                <img id="preview" src="" alt="Image Preview" style="max-width: 100%;
                                    margin-top: 10px; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('partials/footer.php'); ?>

</div>

<!-- Add this script to initialize Notyf.js -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
  const notyf = new Notyf({
    duration: 3000,
    position: {
      x: 'right',
      y: 'top',
    },
  });

  <?php
    // Display success or error alerts
    if (isset($_SESSION['success'])) {
        echo "notyf.success('{$_SESSION['success']}');";
        unset($_SESSION['success']); 
    }

    if (isset($_SESSION['error'])) {
        echo "notyf.error('{$_SESSION['error']}');";
        unset($_SESSION['error']); 
    }
  ?>

  function previewImage() {
    const preview = document.getElementById('preview');
    const file = document.getElementById('image').files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
  }
</script>

<?php include('partials/end.php'); ?>
