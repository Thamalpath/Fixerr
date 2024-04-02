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
        echo '<p><strong>' . $row['sender_type'] . ': </strong>' . $row['message'] . '</p>';
        echo '</div>';
    }
} else {
    echo "No messages available.";
}
?>