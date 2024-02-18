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

// Fetch professional data from the database
$sql = "SELECT * FROM professional";
$result = mysqli_query($con, $sql);

// Check for errors in the query
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
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
            <h1>Professionals</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Professionals</li>
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
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="DataTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Profession</th>
                    <th>Email</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  // Loop through the fetched data and display it in the table
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>{$row['id']}</td>";
                      echo "<td>{$row['fname']} {$row['lname']}</td>";
                      echo "<td>{$row['phone']}</td>";
                      echo "<td>{$row['add_no']} , {$row['address1']} , {$row['address2']} , {$row['zipcode']} , {$row['city']} , {$row['country']}</td>";
                      echo "<td>{$row['profession']}</td>";
                      echo "<td>{$row['email']}</td>";
                      echo "</tr>";
                  }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
<!-- ./wrapper -->

<?php include('partials/end.php'); ?>