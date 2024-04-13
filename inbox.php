<?php
session_start();
include 'config/dbcon.php';

// Check if the user is logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect to the signin page if not logged in
    header("Location: signin.php");
    exit();
}

// Include the database connection file
include 'config/dbcon.php';

// Retrieve the user type from the session
$user_type = $_SESSION['user_type'];

// Initialize variables for sender's name and ID
$sender_name = "";
$sender_id = 0;
$receiver_id = 0; // Initialize receiver_id
$receiver_type = "";
?>

<?php include('partials/header.php'); ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Berlin+Sans+FB:wght@300;400;500;600;700;800&display=swap");

    /* Styles for chat area and form */
    .contact-page-form-area ul li a i {
        font-weight: 500;
    }

    .contact-page-form-area ul li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #fff;   
        border-radius: 8px;
        font-size: 20px;
        font-weight: 500;
    }

    .contact-page-form-area ul li {
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .contact-page-form-area ul {
        padding: 10px;
    }

    .contact-page-form-area ul li {
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .contact-page-form-area .sender-area {
        overflow-y: auto;
        max-height: 743px;
    }

    .chat-area {
        display: block;
        border: 1px solid #102039;
        background-color: #ffffff;
        padding: 20px;
        height: 450px; 
        width: auto;
        font-family: 'Berlin Sans FB', sans-serif;
        border-radius: 5px;
        overflow-y: scroll;
    }

    .chat-area p{
        font-size: 18px;
    }

    .chat-header {
        margin-top: 20px;
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
        margin-top: 20px;
    }

    .chat-form input[type="text"] {
        width: calc(100% - 120px);
        border: 1px solid #102039;
        padding: 5px;
    }

    .chat-form button {
        width: 110px;
        height: 60px;
        padding: 5px;
        background-color: #102039;
        color: #ffffff;
        border-radius: 5px;
        margin-left: 5px;
    }
</style>

<main>
   
 <!-- Breadcrumb area start --> 
<div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
   <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
   <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative">
               <h2 class="breadcrumb__title">Inbox</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="account.php">Account</a></span></li>
                        <li><span>Inbox</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
 <!-- Breadcrumb area end --> 


 <section class="contact-page-section section-space">
   <div class="small-container">
      <div class="row justify-content-center">
        <div id="senders" class="col-xxl-4 col-xl-4 col-lg-4 mx-auo contact-page-form-area sender-area">
            <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                <span class="section-sub-title">All Messages</span>
            </div>
            <ul>
                <?php
                // Determine the sender's information based on the user type
                if ($user_type === 'customer') {
                    // Get the service ID where this customer is assigned
                    $service_id_query = "SELECT id FROM service WHERE id IN (SELECT DISTINCT service_id FROM chat WHERE sender_id = {$_SESSION['user_data']['id']} AND sender_type = 'customer')";
                    $service_id_result = mysqli_query($con, $service_id_query);

                    if ($service_id_result && mysqli_num_rows($service_id_result) > 0) {
                        $service_ids = [];
                        while ($row = mysqli_fetch_assoc($service_id_result)) {
                            $service_ids[] = $row['id'];
                        }

                        // Join chat and professional directly to get professional receiver info
                        $senderQuery = "SELECT p.id, CONCAT(p.fname, ' ', p.lname) AS sender_name
                                        FROM professional p
                                        INNER JOIN chat ON p.id = chat.receiver_id
                                        WHERE chat.sender_type = 'customer' AND chat.service_id IN (" . implode(",", $service_ids) . ")
                                        GROUP BY p.id";
                        $senderResult = mysqli_query($con, $senderQuery);

                        // Check if a row is returned
                        if ($senderResult && mysqli_num_rows($senderResult) > 0) {
                            while ($senderRow = mysqli_fetch_assoc($senderResult)) {
                                $sender_name = $senderRow['sender_name'];
                                $sender_id = $senderRow['id'];
                                echo '<li>';
                                echo '<a href="#" data-sender-id="' . $sender_id . '" data-sender-type="professional" class="sender-link">';
                                echo '<span>' . $sender_name . '</span>';
                                echo '<span><i class="icon-arrow-right-double"></i></span>';
                                echo '</a>';
                                echo '</li>';
                            }
                        }
                    }
                } elseif ($user_type === 'professional') {
                    // Get the service IDs where this professional is assigned as receiver
                    $service_id_query = "SELECT DISTINCT service_id FROM chat WHERE receiver_id = {$_SESSION['user_data']['id']} AND receiver_type = 'professional'";
                    $service_id_result = mysqli_query($con, $service_id_query);
        
                    if ($service_id_result && mysqli_num_rows($service_id_result) > 0) {
                        while ($row = mysqli_fetch_assoc($service_id_result)) {
                            $service_id = $row['service_id'];
        
                            // Fetch customer senders
                            $senderQuery = "SELECT c.id, CONCAT(c.fname, ' ', c.lname) AS sender_name
                                            FROM customer c 
                                            INNER JOIN chat ON c.id = chat.sender_id
                                            WHERE chat.receiver_type = 'professional' AND chat.service_id = $service_id
                                            GROUP BY c.id";
                            $senderResult = mysqli_query($con, $senderQuery);
        
                            if ($senderResult && mysqli_num_rows($senderResult) > 0) {
                                while ($senderRow = mysqli_fetch_assoc($senderResult)) {
                                    $sender_name = $senderRow['sender_name'];
                                    $sender_id = $senderRow['id'];
                                    echo '<li>';
                                    echo '<a href="#" data-sender-id="' . $sender_id . '" data-sender-type="customer" class="sender-link">';
                                    echo '<span>' . $sender_name . '</span>';
                                    echo '<span><i class="icon-arrow-right-double"></i></span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                            }
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-xxl-8 col-xl-8 col-lg-8 mx-auto"> 
            <div class="contact-page-form-area">
                <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                    <span class="section-sub-title">Inbox</span>
                    <div id="chatHeader" class="chat-header"></div>
                    <div id="chatArea" class="chat-area">
                    <!-- Chat messages will be displayed here -->
                    </div>
                    <form id="chatForm" class="chat-form">
                        <input type="hidden" id="receiver_id" value="">
                        <input type="hidden" id="receiver_type" value="">
                        <input type="hidden" id="sender_type" value="<?php echo $user_type; ?>">
                        <input type="text" id="messageInput" placeholder="Type your message...">
                        <button type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
   </div>
 </section>

</main>

<!-- Footer area start -->
<?php include('partials/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        // Handle sender link click event
        $('.sender-link').on('click', function(e) {
            e.preventDefault();
            var senderId = $(this).data('sender-id');
            var senderType = $(this).data('sender-type');

            // Set receiver type based on sender type
            var receiverType = senderType === 'customer' ? 'professional' : 'customer';
            $('#receiver_type').val(receiverType);
            $('#receiver_id').val(senderId);

            // Update chat header
            var senderName = $(this).find('span:first').text();
            $('#chatHeader').text('Chat with ' + senderName);

            // Perform AJAX request to retrieve messages for the selected sender
            $.ajax({
                url: 'retrieveMessages.php',
                method: 'POST',
                data: { sender_id: senderId, sender_type: senderType, receiver_type: receiverType },
                dataType: 'html',
                success: function(data) {
                    $('#chatArea').html(data);
                }
            });
        });

        // Handle form submission event
        $("#chatForm").on("submit", function(e) {
            e.preventDefault();
            
            // Get input values
            var message = $("#messageInput").val();
            var receiverId = $("#receiver_id").val();
            var receiverType = $("#receiver_type").val();
            var senderType = $("#sender_type").val();
            
            // Perform AJAX request to send message
            $.ajax({
                url: "insertMessage.php",
                method: "POST",
                data: { message: message, receiver_id: receiverId, receiver_type: receiverType, sender_type: senderType },
                dataType: "text",
                success: function(response) {
                    // Handle success response
                    $("#messageInput").val(""); // Clear input field after sending message
                }
            });
        });

        // Refresh chat area at regular intervals
        setInterval(function(){
            // Perform AJAX request to retrieve real-time chat updates
            $.ajax({
                url: "realTimeChat.php",
                method: "POST",
                data: { receiver_id: $('#receiver_id').val() }, 
                dataType: "html",
                success: function(data) {
                    $('#chatArea').html(data); 
                }
            });
        }, 3000); 

    });
</script>