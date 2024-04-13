<?php
session_start();
include 'config/dbcon.php';

// Check if the user is logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect to the signin page if not logged in
    header("Location: signin.php");
    exit();
}

// ====================================== SEND MESSAGE ======================================

// Check if the user is a customer or professional
$user_type = $_SESSION['user_type'];

// Initialize variables for sender's name and ID
$sender_name = "";
$sender_id = 0;

// Get service ID from URL parameter
$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_type === 'customer') {
    // Get the service ID from the URL parameter
    $service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Query to get the professional's name and ID based on the service ID
    $senderQuery = "SELECT p.id, CONCAT(p.fname, ' ', p.lname) AS sender_name
                    FROM professional p 
                    INNER JOIN service s ON p.id = s.professional_id 
                    WHERE s.id = $service_id";
    $senderResult = mysqli_query($con, $senderQuery);

    // Check if a row is returned
    if ($senderResult && mysqli_num_rows($senderResult) > 0) {
        $senderRow = mysqli_fetch_assoc($senderResult);
        $sender_name = $senderRow['sender_name'];
        $sender_id = $senderRow['id'];
    }
} 

// Handle sending message
if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $receiver_id = $sender_id; // Receiver is the professional
    $receiver_type = 'professional';
    
    // Insert the message into the chat table
    $insertQuery = "INSERT INTO chat (service_id, sender_id, sender_type, receiver_id, receiver_type, message, sent_time) 
                    VALUES ($service_id, {$_SESSION['user_data']['id']}, '$user_type', $receiver_id, '$receiver_type', '$message', NOW())";
    mysqli_query($con, $insertQuery);
}


// =================================== RETRIEVE MESSAGE =====================================

// Retrieve chat messages between the signed-in customer user and the professional user
$chatQuery = "SELECT c.id, c.sender_id, c.sender_type, c.receiver_id, c.receiver_type, c.message, c.sent_time
              FROM chat c
              WHERE ((c.sender_id = {$_SESSION['user_data']['id']} AND c.receiver_id = $sender_id AND c.sender_type = 'customer')
                 OR (c.sender_id = $sender_id AND c.receiver_id = {$_SESSION['user_data']['id']} AND c.sender_type = 'professional'))
              ORDER BY c.sent_time ASC";
$chatResult = mysqli_query($con, $chatQuery);


// ==================================== RETRIEVE CATEGORY ====================================

// Retrieve all categories
$category = "SELECT `id`, `cat_name` FROM `category` WHERE `status` = 1";
$result1 = mysqli_query($con, $category);


// ================================== RETRIEVE SERVICE DATA ==================================

// Retrieve service details for the given service
$serviceQuery = "SELECT `id`, `profession_name`, `description`, `image`
          FROM `service` 
          WHERE `id` = $service_id AND `status` = 1";
$serviceResult = mysqli_query($con, $serviceQuery);

// Retrieve reviews for the given service
$reviewQuery = "SELECT r.`message`, r.`rate`, r.`datetime`, c.`fname`, c.`lname`
                FROM `review` r
                INNER JOIN `customer` c ON r.`customer_id` = c.`id`
                WHERE r.`service_id` = $service_id
                ORDER BY RAND()
                LIMIT 8";
$reviewResult = mysqli_query($con, $reviewQuery);

// Handle the review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && isset($_POST['rate']) && isset($_POST['service_id'])) {
    // Sanitize and validate form data
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $rate = floatval($_POST['rate']); // Change this line
    $service_id = intval($_POST['service_id']);
    $customer_id = $_SESSION['user_data']['id'];
    
    // Insert data into the review table
    $query = "INSERT INTO `review` (`message`, `rate`, `datetime`, `customer_id`, `service_id`) 
              VALUES ('$message', '$rate', NOW(), '$customer_id', '$service_id')";
    
    $result = mysqli_query($con, $query);
    
    if ($result) {
        // Success alert
        $_SESSION['success'] = "Your review has been submitted successfully.";
    } else {
        // Error alert
        $_SESSION['error'] = "Failed to submit your review. Please try again.";
    }
    
    // Redirect back to the service details page
    header("Location: service-details.php?id=$service_id");
    exit();
}

// Handle the order submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderDescription']) && $service_id > 0) {
    $orderDescription = mysqli_real_escape_string($con, $_POST['orderDescription']);
    $customer_id = $_SESSION['user_data']['id'];
    
    // Insert data into the order table
    $orderQuery = "INSERT INTO `order` (`date`, `time`, `description`, `customer_id`, `service_id`) 
                   VALUES (CURDATE(), CURTIME(), '$orderDescription', '$customer_id', '$service_id')";
    
    $orderResult = mysqli_query($con, $orderQuery);
    
    if ($orderResult) {
      $_SESSION['success'] = "Order placed successfully.";
    } else {
      $_SESSION['error'] = "Failed to place the order. Please try again.";
    }
  }
?>


<?php include('partials/header.php'); ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Berlin+Sans+FB:wght@300;400;500;600;700;800&display=swap");

    /* Styles for chat area and form */
    .chat-area {
        /* display: none;  */
        border: 1px solid #102039;
        background-color: #ffffff;
        padding: 20px;
        height: 300px;
        width: auto;
        overflow-y: scroll;
        font-family: 'Berlin Sans FB', sans-serif;
        border-radius: 0 0 5px 5px;
        scrollbar-color: #102039 #ffffff;
    }

    .chat-header {
        background-color: #102039;
        color: #ffffff;
        padding: 10px;
        font-family: 'Berlin Sans FB', sans-serif;
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        border-radius: 5px 5px 0 0;
    }

    .chat-form {
        /* display: none; */
        margin-top: 20px;
    }

    .chat-form input[type="text"] {
        width: calc(100% - 100px);
        border: 1px solid #102039;
        padding: 5px;
    }

    .start-chat-container input {
        margin-top: 20px;
        border: 1px solid #102039;
    }

    .chat-form button {
        width: 90px;
        height: 60px;
        padding: 5px;
        background-color: #102039;
        color: #ffffff;
        border-radius: 5px;
        margin-left: 5px;
    }

    .pay-btn .chat-btn{
        height: 80px;
        font-size: 20px;
    }

    .sent-by-me {
        text-align: right;
    }

    .sent-by-other {
        text-align: left;
    }
</style>

<!-- Bootstrap Modal for Order -->
<div class="modal fade" id="makeOrderModal" tabindex="-1" aria-labelledby="makeOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="makeOrderModalLabel">Make an Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
            // Fetch professional's first and last name based on service ID
            $professionalQuery = "SELECT p.`fname`, p.`lname` 
                                FROM `service` s
                                INNER JOIN `professional` p ON s.`professional_id` = p.`id`
                                WHERE s.`id` = $service_id";
            $professionalResult = mysqli_query($con, $professionalQuery);
            $professionalRow = mysqli_fetch_assoc($professionalResult);
            $professionalName = $professionalRow ? $professionalRow['fname'] . ' ' . $professionalRow['lname'] : 'Professional Not Found';
        ?>
        <label for="orderDescription" class="form-label fw-bold">Professional:</label> <h7> <?php echo $professionalName; ?></h7>
        <form method="post" action="service-details.php?id=<?php echo $service_id; ?>">
          <div class="mb-3">
            <label for="orderDescription" class="form-label fw-bold">Description:</label>
            <textarea class="form-control" id="orderDescription" name="orderDescription" style="height: 200px; font-size: 16px;" required></textarea>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
            <button type="submit" class="primary-btn-4 btn-hover"> 
                Submit Order<span style="top: 147.172px; left: 108.5px;"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<main>
   
    <!-- Breadcrumb area start --> 
    <div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
        <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
        <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
        <div class="small-container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper p-relative">
                    <h2 class="breadcrumb__title">Service Details</h2>
                    <div class="breadcrumb__menu">
                        <nav>
                            <ul>
                                <li><span><a href="category.php">Category</a></span></li>
                                <li><span>Service Details</span></li>
                            </ul>
                        </nav>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end --> 


    <section class="service-details-page section-space">
        <div class="small-container">
            <div class="row">
                <div class="col-xxl-7 col-xl-7 col-lg-7">
                    <div class="service-details-page-content">
                        <?php
                            // Check if query execution is successful 
                            if ($serviceResult) {

                                // Check if any service details are available
                                if (mysqli_num_rows($serviceResult) > 0) {

                                    // Output service details
                                    $serviceDetails = mysqli_fetch_assoc($serviceResult);
                                    echo '<figure class="w-img">';
                                    echo '<img src="uploads/service/' . basename($serviceDetails['image']) . '" alt="">';
                                    echo '</figure>';
                                    echo '<h3 class="service-details-title mt-45 mb-25">' . $serviceDetails['profession_name'] . '</h3>';
                                    echo '<p class="mb-25">' . $serviceDetails['description'] . '</p>';
                                } else {
                                    echo "No details available for this service.";
                                }
                            } else {
                                echo "Failed to retrieve service details from the database.";
                            }

                            mysqli_close($con);
                        ?>
                        <br>

                        <h4 class="post-box-comments-title mt-100">Customer Reviews</h4>
                        <?php while ($row = mysqli_fetch_assoc($reviewResult)) { ?>
                            <div class="post-box-comments-box p-relative mt-40 mb-40">
                                <div class="postbox__comment-text">
                                    <div class="postbox__comment-name">
                                        <h5><?php echo $row['fname'] . ' ' . $row['lname']; ?></h5>
                                        <span class="post-meta"><?php echo $row['datetime']; ?></span>
                                    </div>
                                    <ul class="postbox__comment_ratings">
                                        <?php 
                                        // Full stars
                                        for ($i = 0; $i < floor($row['rate']); $i++) { ?>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        <?php } 
                                        
                                        // Half star if applicable
                                        if ($row['rate'] - floor($row['rate']) >= 0.5) { ?>
                                            <li><i class="bi bi-star-half"></i></li>
                                        <?php } ?>
                                    </ul>
                                    <p class="pt-25 pb-25"><?php echo $row['message']; ?></p>
                                    <!-- <div class="postbox__comment-reply">
                                        <a href="#">Reply</a>
                                    </div> -->
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                        
                        <div class="postbox__comment-form mt-60">
                            <h4 class="postbox__comment-form-title mb-50">Leave a Comment</h4>
                            <form method="post" action="#">
                                <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
                                <div class="row">
                                    <div class="col-xxl-12">
                                        <div class="postbox__comment-input">
                                            <label>Star Rating</label>
                                            <!-- Include RateYo star rating plugin -->
                                            <div id="rateYo"></div>
                                            <input type="hidden" name="rate" id="ratingInput" value="0">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 mt-40">
                                        <div class="postbox__comment-input">
                                            <label>Your Review</label>
                                            <textarea name="message" placeholder="Write Message" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="postbox__comment-btn">
                                            <button type="submit" class="primary-btn-1 btn-hover">
                                                POST comment
                                                <span style="top: 147.172px; left: 108.5px;"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 col-xl-5 col-lg-5">
                    <div class="service-sidebar">
                        <aside>
                            <div class="service-widget-1 mb-30">
                                <h5>Main Categories</h5>
                                <ul>
                                    <?php
                                    // Check if query execution is successful 
                                    if ($result1 && mysqli_num_rows($result1) > 0) {
                                        // Output each category
                                        while ($row = mysqli_fetch_assoc($result1)) {
                                            echo '<li>';
                                            echo '<a href="sub-category.php?category_id=' . $row['id'] . '" class="active">';
                                            echo '<span>' . $row['cat_name'] . '</span>';
                                            echo '<span><i class="icon-arrow-right-double"></i></span>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                    } else {
                                        echo "No categories available.";
                                    }
                                    ?>
                                </ul>
                            </div>

                            <div class="chat-widget-1 mb-30">
                                <div id="chatHeader" class="chat-header">Chat</div>
                                <div id="chatArea" class="chat-area">
                                    <?php
                                    // Display messages
                                    if ($chatResult && mysqli_num_rows($chatResult) > 0) {
                                        while ($chatRow = mysqli_fetch_assoc($chatResult)) {
                                            $messageClass = ($chatRow['sender_type'] === 'customer') ? 'sent-by-me' : 'sent-by-other';
                                            $messageSender = ($chatRow['sender_type'] === 'customer') ? 'Me' : $sender_name;
                                    ?>
                                            <div>
                                                <p class="<?php echo $messageClass; ?>">
                                                    <strong>
                                                        <span style="color: <?php echo $messageClass === 'sent-by-me' ? '#102039' : '#FF9800'; ?>;">
                                                            <?php echo $messageSender; ?>:
                                                        </span>
                                                    </strong>
                                                    <?php echo $chatRow['message']; ?>
                                                </p>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<div class='chat-message chat-message-empty'>No messages found.</div>";
                                    }
                                    ?>
                                </div>
                                <form id="chatForm" class="chat-form" method="POST">
                                    <input type="text" id="messageInput" name="message" placeholder="Type your message...">
                                    <button type="submit">Send</button>
                                </form>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 form-group text-center mt-50">
                                    <button type="button" class="primary-btn-4 pay-btn btn-hover w-100" data-bs-toggle="modal" data-bs-target="#makeOrderModal"> 
                                        Make an Order<span style="top: 147.172px; left: 108.5px;"></span>
                                    </button>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main> 

 <!-- Footer area start -->
<?php include('partials/footer.php'); ?>

<script>
    $(function () {
        $("#rateYo").rateYo({
            starWidth: "30px",
            rating: 0,
            onSet: function (rating, rateYoInstance) {
                $('#ratingInput').val(rating);
            }
        });
    });
</script>