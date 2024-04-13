<style>
    .sent-by-me {
        text-align: right;
    }

    .sent-by-other {
        text-align: left;
    }

    /* .sent-by-me,
    .sent-by-other {
        padding: 5px 10px;
        border-radius: 10px;
        background-color: #f0f0f0;
        margin: 5px;
    } */
</style>

<?php
session_start();
include 'config/dbcon.php';

// Get the sender ID and receiver ID from the session
$sender_id = $_SESSION['user_data']['id'];
$receiver_id = $_POST['receiver_id'];

// Determine the sender type based on the session user type
if ($_SESSION['user_type'] === 'customer') {
    $sender_type = 'customer';
    $receiver_type = 'professional';
} elseif ($_SESSION['user_type'] === 'professional') {
    $sender_type = 'professional';
    $receiver_type = 'customer';
}

// Query to retrieve new chat messages between the sender and receiver
$query = "SELECT * FROM chat WHERE 
          ((sender_id = $sender_id AND sender_type = '$sender_type' AND receiver_id = $receiver_id AND receiver_type = '$receiver_type') 
          OR (sender_id = $receiver_id AND sender_type = '$receiver_type' AND receiver_id = $sender_id AND receiver_type = '$sender_type')) 
          ORDER BY sent_time ASC";

$result = mysqli_query($con, $query);

// Display chat messages
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div>';
        // Determine if the message is sent by "Me" or the other party
        if ($row['sender_id'] == $_SESSION['user_data']['id'] && $row['sender_type'] == $_SESSION['user_type']) {
            echo '<p class="sent-by-me"><strong><span style="color: #102039;">Me:</span> </strong>' . $row['message'] . '</p>';
        } else {
            // Fetch the sender's name
            $sender_name_query = ($row['sender_type'] === 'customer') ? 
                "SELECT CONCAT(fname, ' ', lname) AS sender_name FROM customer WHERE id = {$row['sender_id']}" :
                "SELECT CONCAT(fname, ' ', lname) AS sender_name FROM professional WHERE id = {$row['sender_id']}";
                
            $sender_name_result = mysqli_query($con, $sender_name_query);
            if ($sender_name_result && mysqli_num_rows($sender_name_result) > 0) {
                $sender_name_row = mysqli_fetch_assoc($sender_name_result);
                echo '<p class="sent-by-other"><strong><span style="color: #FF9800;">' . $sender_name_row['sender_name'] . ': </span> </strong>' . $row['message'] . '</p>';
            }
        }
        echo '</>';
    }
} else {
    echo "No new messages available.";
}
?>
