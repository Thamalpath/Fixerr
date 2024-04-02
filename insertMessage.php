<?php
session_start();
include 'config/dbcon.php';

// Get the sender ID, receiver ID, and message from the form submission
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

// Regular expressions to identify prohibited content
$phone_regex = '/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/';
$email_regex = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';
$skype_regex = '/\bSkype: *[a-zA-Z0-9][a-zA-Z0-9-_.]{5,31}\b/';
$facebook_regex = '/\b(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)\b/';
$instagram_regex = '/\b(?:https?:\/\/)?(?:www\.)?instagram\.com\/[a-zA-Z0-9_]+\b/';

// Check for prohibited content in the message
if (preg_match($phone_regex, $message)) {
    $_SESSION['error'] = "Phone numbers are not allowed.";
} elseif (preg_match($email_regex, $message)) {
    $_SESSION['error'] = "Email addresses are not allowed.";
} elseif (preg_match($skype_regex, $message)) {
    $_SESSION['error'] = "Skype usernames are not allowed.";
} elseif (preg_match($facebook_regex, $message)) {
    $_SESSION['error'] = "Facebook profile links are not allowed.";
} elseif (preg_match($instagram_regex, $message)) {
    $_SESSION['error'] = "Instagram profile links are not allowed.";
} else {
    // Get message data
    $sender_id = $_SESSION['user_data']['id'];
    $sender_type = $_POST['sender_type'];
    $receiver_type = $sender_type == 'customer' ? 'professional' : 'customer';

    // Insert message query
    $insert_query = "INSERT INTO chat (sender_id, sender_type, receiver_type, receiver_id, message, sent_time) 
                     VALUES ($sender_id, '$sender_type', '$receiver_type', '$receiver_id', '$message', NOW())";

    // Execute query 
    mysqli_query($con, $insert_query);
}

// Return success response or error message
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
} else {
    echo "Message inserted";
}
?>

<!-- Include Notyf JS Library -->
<link rel="stylesheet" type="text/css" href="path/to/notyf.min.css" />
<script type="text/javascript" src="path/to/notyf.min.js"></script>
<!-- Initialize Notyf JS -->
<script type="text/javascript">
var notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'right',
        y: 'top',
    },
})

<?php
// Display error alert if there is an error message in the session variable
if (!empty($_SESSION['error'])) {
    echo 'notyf.error("' . $_SESSION['error'] . '");';
}
?>
</script>
