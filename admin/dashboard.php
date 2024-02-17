<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<?php
session_start();

// Check if user is not logged in, redirect to sign-in page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Include database connection
include '../config/dbcon.php';

// Fetch counts from database
$service_count_query = "SELECT COUNT(*) as count FROM service";
$professional_count_query = "SELECT COUNT(*) as count FROM professional";
$customer_count_query = "SELECT COUNT(*) as count FROM customer";

$service_count_result = mysqli_query($con, $service_count_query);
$professional_count_result = mysqli_query($con, $professional_count_query);
$customer_count_result = mysqli_query($con, $customer_count_query);

// Check if query execution was successful
if ($service_count_result && $professional_count_result && $customer_count_result) {
    $service_count_row = mysqli_fetch_assoc($service_count_result);
    $professional_count_row = mysqli_fetch_assoc($professional_count_result);
    $customer_count_row = mysqli_fetch_assoc($customer_count_result);

    // Get counts
    $service_count = $service_count_row['count'];
    $professional_count = $professional_count_row['count'];
    $customer_count = $customer_count_row['count'];
} else {
    // Handle error if query execution fails
    echo "Error: " . mysqli_error($con);
}

// Close connection
mysqli_close($con);
?>

<?php include('partials/header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partials/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include('partials/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $service_count; ?></h3>

                <p>Services</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="service.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $professional_count; ?></h3>

                <p>Professionals</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="professional.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $customer_count; ?></h3>

                <p>Customers</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="customer.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('partials/footer.php'); ?>

</div>
<!-- ./wrapper -->

<?php include('partials/end.php'); ?>

<!-- Add this script to initialize Notyf.js -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>