<style>
    .sent-by-me {
        text-align: right;
    }

    .sent-by-other {
        text-align: left;
    }
</style>

<?php
session_start();
include 'config/dbcon.php';

// Get the sender ID, sender type, and receiver type from the AJAX request
$sender_id = $_POST['sender_id'];
$sender_type = $_POST['sender_type'];
$receiver_type = $_POST['receiver_type'];

// Query to retrieve messages for the selected sender and receiver
$query = "SELECT * FROM chat WHERE ((sender_id = $sender_id AND sender_type = '$sender_type') OR (receiver_id = $sender_id AND receiver_type = '$sender_type')) AND ((receiver_id = {$_SESSION['user_data']['id']} AND receiver_type = '{$_SESSION['user_type']}') OR (sender_id = {$_SESSION['user_data']['id']} AND sender_type = '{$_SESSION['user_type']}')) ORDER BY sent_time ASC";

$result = mysqli_query($con, $query);

// Display chat messages
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div>';
        if ($_SESSION['user_type'] === 'customer') {
            if ($row['sender_type'] === 'customer') {
                echo '<p class="sent-by-me"><strong><span style="color: #102039;">Me:</span> </strong>' . $row['message'] . '</p>';
            } else {
                // Fetch the professional's name
                $professional_query = "SELECT CONCAT(fname, ' ', lname) AS professional_name FROM professional WHERE id = {$row['sender_id']}";
                $professional_result = mysqli_query($con, $professional_query);
                if ($professional_result && mysqli_num_rows($professional_result) > 0) {
                    $professional_row = mysqli_fetch_assoc($professional_result);
                    echo '<p class="sent-by-other"><strong><span style="color: #FF9800;">' . $professional_row['professional_name'] . ': </span> </strong>' . $row['message'] . '</p>';
                }
            }
        } elseif ($_SESSION['user_type'] === 'professional') {
            if ($row['sender_type'] === 'professional') {
                echo '<p class="sent-by-me"><strong><span style="color: #102039;">Me:</span> </strong>' . $row['message'] . '</p>';
            } else {
                // Fetch the customer's name
                $customer_query = "SELECT CONCAT(fname, ' ', lname) AS customer_name FROM customer WHERE id = {$row['sender_id']}";
                $customer_result = mysqli_query($con, $customer_query);
                if ($customer_result && mysqli_num_rows($customer_result) > 0) {
                    $customer_row = mysqli_fetch_assoc($customer_result);
                    echo '<p class="sent-by-other"><strong><span style="color: #FF9800;">' . $customer_row['customer_name'] . ': </span> </strong>' . $row['message'] . '</p>';
                }
            }
        }
        echo '</div>';
    }
} else {
    echo "No new messages available.";
}
?>