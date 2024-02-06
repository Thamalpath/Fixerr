<?php
session_start(); 

include '../config/dbcon.php';

// Fetch category data from the database
$sql = "SELECT * FROM category";
$result = mysqli_query($con, $sql);

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
            <h1>All Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
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
                    <th>Cat ID</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  // Loop through the fetched data and display it in the table
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>{$row['id']}</td>";
                      echo "<td>{$row['cat_name']}</td>";
                      echo "<td><img src='{$row['image']}' style='max-width: 100px; max-height: 100px;' alt='Category Image'></td>";
                      echo "<td>";
                        if ($row['status'] == 1) {
                            echo "Available";
                        } elseif ($row['status'] == 0) {
                            echo "Unavailable";
                        } else {
                            echo "Unknown";
                        }
                      echo "</td>";
                      echo "<td class='text-center'><a href='category-edit.php?id={$row['id']}' class='btn btn-primary w-75'>Edit</a></td>"; 
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