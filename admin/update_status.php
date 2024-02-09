<!-- Notyf -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

<?php
session_start(); 

include '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = $_POST['service_id'];
    $newStatus = $_POST['new_status'];

    // Update the status in the database
    $updateSql = "UPDATE service SET status = $newStatus WHERE id = $serviceId";

    if (mysqli_query($con, $updateSql)) {
        // Set success message in session
        $_SESSION['success'] = "Status updated successfully";
        echo "success";
    } else {
        // Set error message in session
        $_SESSION['error'] = "Error updating status: " . mysqli_error($con);
        echo "error";
    }
}

mysqli_close($con);
?>


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
