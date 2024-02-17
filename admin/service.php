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

// Fetch unique service data from the database
$sql = "SELECT DISTINCT service.id, service.profession_name, service.description, service.image, service.status, professional.fname, professional.lname, category.cat_name, sub_category.sub_cat_name
        FROM service service
        LEFT JOIN professional professional ON service.professional_id = professional.id
        LEFT JOIN category category ON service.category_id = category.id
        LEFT JOIN sub_category sub_category ON service.sub_category_id = sub_category.id";

$result = mysqli_query($con, $sql);

// Check for SQL errors
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($con));
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
            <h1>All Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Services</li>
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
                    <th>Profession Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Professional</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Check if $result is valid before fetching data
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through the fetched data and display it in the table
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['profession_name']}</td>";
                            echo "<td>" . implode(' ', array_slice(str_word_count($row['description'], 1), 0, 10)) . "...</td>"; 
                            echo "<td><img src='../{$row['image']}' style='max-width: 100px; max-height: 100px;' alt='Service Image'></td>";
                            echo "<td>{$row['fname']} {$row['lname']}</td>"; 
                            echo "<td>{$row['cat_name']}</td>"; 
                            echo "<td>{$row['sub_cat_name']}</td>"; 
                            echo "<td>";
                                if ($row['status'] == 1) {
                                    echo "Approved";
                                } elseif ($row['status'] == 0) {
                                    echo "Pending";
                                } 
                            echo "</td>";
                            echo "<td class='text-center'>";
                                if ($row['status'] == 1) {
                                    echo "<button class='btn btn-success w-100 mt-3' onclick='changeStatus({$row['id']}, 0)'>Approved</button>";
                                } elseif ($row['status'] == 0) {
                                    echo "<button class='btn btn-warning w-100 mt-3' onclick='changeStatus({$row['id']}, 1)'>Pending</button>";
                                } 
                            echo "</td>";
                            }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
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

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'right',
        y: 'top',
    },
});
</script>


<script>
function changeStatus(serviceId, newStatus) {
    $.ajax({
        url: 'update_status.php',
        type: 'POST',
        data: { service_id: serviceId, new_status: newStatus },
        success: function(response) {
            // Display success message with Notyf JS
            notyf.success('Status updated successfully');
            location.reload();
        },
        error: function(xhr, status, error) {
            // Display error message with Notyf JS
            console.error('Error updating status:', error);
        }
    });
}
</script>
