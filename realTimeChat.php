<?php
session_start();
include 'config/dbcon.php';

// Get the receiver ID, receiver type, and sender type from the AJAX request
$receiver_id = $_POST['receiver_id'];
$receiver_type = $_POST['receiver_type'];
$sender_type = $_POST['sender_type'];

// Query to retrieve real-time chat messages
$query = "SELECT * FROM chat WHERE 
          ((sender_id = $receiver_id AND sender_type = '$receiver_type') OR 
           (receiver_id = $receiver_id AND receiver_type = '$receiver_type')) AND
          ((sender_id = {$_SESSION['user_data']['id']} AND sender_type = '{$_SESSION['user_type']}') OR
           (receiver_id = {$_SESSION['user_data']['id']} AND receiver_type = '{$_SESSION['user_type']}'))
          ORDER BY sent_time ASC";

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