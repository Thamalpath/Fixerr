<?php
session_start();
include 'config/dbcon.php';

// Check if the user is logged in as a customer
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer') {
    // User is logged in as a customer, show the chat widget
    $showChatWidget = true;
} else {
    // User is not logged in as a customer, hide the chat widget
    $showChatWidget = false;
}

// Retrieve all categories
$category = "SELECT `id`, `cat_name` FROM `category` WHERE `status` = 1";
$result1 = mysqli_query($con, $category);

// Get service ID from URL parameter
$service_id = $_GET['id'];

// Retrieve service details for the given service
$query = "SELECT `id`, `profession_name`, `description`, `image` 
          FROM `service` 
          WHERE `id` = $service_id AND `status` = 1";

$result = mysqli_query($con, $query);

?>


<?php include('partials/header.php'); ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap");

    @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

    /* Styles for chat area and form */
    .chat-area {
        /* display: none;  */
        border: 1px solid #ea1826;
        background-color: #ffffff;
        padding: 20px;
        height: 300px;
        width: auto;
        overflow-y: scroll;
        font-family: "Roboto", sans-serif;
        border-radius: 0 0 5px 5px;
        scrollbar-color: #ea1826 #ffffff;
    }

    .chat-header {
        background-color: #ea1826;
        color: #ffffff;
        padding: 10px;
        font-family: "Roboto", sans-serif;
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
        border: 1px solid #ea1826;
        padding: 5px;
    }

    .start-chat-container input {
        margin-top: 20px;
        border: 1px solid #ea1826;
    }

    .chat-form button {
        width: 90px;
        height: 60px;
        padding: 5px;
        background-color: #ea1826;
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
                            if ($result) {

                                // Check if any service details are available
                                if (mysqli_num_rows($result) > 0) {

                                    // Output service details
                                    $serviceDetails = mysqli_fetch_assoc($result);
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

                        <!-- <h4 class="post-box-comments-title">02 Comments</h4>

                        <div class="post-box-comments-box p-relative mt-40 mb-40">
                            <div class="postbox__comment-avatar">
                                <img src="assets/imgs/blog/post-box-1.jpg" alt="">
                            </div>
                            <div class="postbox__comment-text ">
                                <div class="postbox__comment-name">                     
                                    <h5><a href="#">Ralph edwards</a></h5>
                                    <span class="post-meta"> March 20, 2023 at 2:37 pm</span>
                                </div>
                                <ul class="postbox__comment_ratings">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <p class="pt-25 pb-25">Neque porro est qui dolorem ipsum quia quaed inventor veritatis et quasi architecto var sed efficitur turpis gilla sed sit amet finibus eros. Lorem Ipsum is simply dummy</p>
                                <div class="postbox__comment-reply">
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="post-box-comments-box p-relative mt-40 mb-40">
                            <div class="postbox__comment-avatar">
                                <img src="assets/imgs/blog/post-box-2.jpg" alt="">
                            </div>
                            <div class="postbox__comment-text ">
                                <div class="postbox__comment-name">                     
                                    <h5><a href="#">Albert Flores</a></h5>
                                    <span class="post-meta"> March 20, 2023 at 2:37 pm</span>
                                </div>
                                <ul class="postbox__comment_ratings">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <p class="pt-25 pb-25">Neque porro est qui dolorem ipsum quia quaed inventor veritatis et quasi architecto var sed efficitur turpis gilla sed sit amet finibus eros. Lorem Ipsum is simply dummy</p>
                                <div class="postbox__comment-reply">
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="postbox__comment-form mt-60">
                            <h4 class="postbox__comment-form-title mb-50">Leave a Comment</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                        <div class="postbox__comment-input">
                                        <label>Your Name*</label>
                                        <input type="text" placeholder="Your Name*">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                        <div class="postbox__comment-input">
                                        <label>Your Email*</label>
                                        <input type="email" placeholder="Your Email*">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="postbox__comment-input">
                                        <label>Your Review*</label>
                                        <textarea placeholder="Write Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="postbox__comment-btn">
                                        <button  type="submit" class="primary-btn-1 btn-hover">
                                            POST comment
                                            <span style="top: 147.172px; left: 108.5px;"></span>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> -->
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
                                            echo '<a class="active">';
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

                            <?php if($showChatWidget): ?>
                                <div class="chat-widget-1 mb-30">
                                    <div id="chatHeader" class="chat-header">Chat</div>
                                    <div id="chatArea" class="chat-area">
                                        <!-- Chat messages will be displayed here -->
                                    </div>
                                    <form id="chatForm" class="chat-form">
                                        <input type="text" id="messageInput" placeholder="Type your message...">
                                        <button type="submit">Send</button>
                                    </form>
                                </div>
                            <?php endif; ?>
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
    document.addEventListener("DOMContentLoaded", function() {
        const chatArea = document.getElementById("chatArea");
        const chatForm = document.getElementById("chatForm");

        chatForm.addEventListener("submit", function(e) {
            e.preventDefault();
            // Implement your logic to send the message
            const message = document.getElementById("messageInput").value.trim();
            if (message !== "") {
                sendMessage(message);
                displayMessage("You", message, "right");
                document.getElementById("messageInput").value = "";
            }
        });

        function sendMessage(message) {
            const sender = "Professional";
            displayMessage(sender, message, "left");
        }

        function displayMessage(sender, message, alignment) {
            const messageDiv = document.createElement("div");
            messageDiv.innerHTML = `<strong>${sender}:</strong> ${message}`;
            messageDiv.classList.add("message");
            messageDiv.classList.add(alignment);
            chatArea.appendChild(messageDiv);
        }
    });
</script>