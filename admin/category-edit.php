<!-- Notyf -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<?php
session_start();

// Check if user is not logged in, redirect to sign-in page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
?>

<?php
include '../config/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $category_id = $_GET['id']; // Assuming you are passing category id via URL
    $cat_name = mysqli_real_escape_string($con, $_POST['cat_name']);
    $status = isset($_POST['status']) ? ($_POST['status'] == 'available' ? 1 : 0) : 0;

    // Handle image upload if necessary
    if ($_FILES['image']['name']) {
        // Delete previous image
        $sql_select_image = "SELECT image FROM category WHERE id='$category_id'";
        $result_select_image = mysqli_query($con, $sql_select_image);
        $row_select_image = mysqli_fetch_assoc($result_select_image);
        $old_image_path = $row_select_image['image'];
        if ($old_image_path && file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        // Upload new image
        $target_dir = "uploads/category/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newImageName = uniqid() . '.' . $imageFileType;
        $newFilePath = $target_dir . $newImageName;

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
            $_SESSION['error'] = "Sorry, only JPG, JPEG files are allowed.";
            header("Location: category-edit.php?id=$category_id");
            exit();
        }

        // Upload file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newFilePath)) {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            header("Location: category-edit.php?id=$category_id");
            exit();
        }

        // Update category data in the database with the new image path
        $sql = "UPDATE category SET cat_name='$cat_name', status='$status', image='$newFilePath' WHERE id='$category_id'";
    } else {
        // Update category data in the database without updating the image path
        $sql = "UPDATE category SET cat_name='$cat_name', status='$status' WHERE id='$category_id'";
    }

    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location: category.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating category: " . mysqli_error($con);
        header("Location: category-edit.php?id=$category_id");
        exit();
    }
}

// Fetch category data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $sql = "SELECT * FROM category WHERE id = $category_id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($con);
        header("Location: category.php");
        exit();
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
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="category.php">Categories</a></li>
              <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="card-title">Edit Category</h3>
              </div>

              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cat_name">Category Name</label>
                                <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $row['cat_name']; ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                  <option value="available" <?php if ($row['status'] == 1) echo 'selected'; ?>>Available</option>
                                  <option value="unavailable" <?php if ($row['status'] == 0) echo 'selected'; ?>>Unavailable</option>
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
                              <img id="preview" src="<?php echo $row['image']; ?>" alt="Image Preview" style="width: 400px; height: auto;
                                  margin-top: 30px; display: none;">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="card-footer mt-5">
                    <button type="submit" class="btn btn-primary">Update</button>
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
