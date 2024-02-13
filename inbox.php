<?php
session_start();

// Check if the user is a professional
if (!isset($_SESSION['user_data']) || $_SESSION['user_type'] !== 'professional' && $_SESSION['user_type'] !== 'customer') {
    // Redirect to a different page or display an error message
    header("Location: signin.php");
    exit();
}

include 'config/dbcon.php';

mysqli_close($con);
?>


<?php include('partials/header.php'); ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap");

    @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

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

    .contact-page-form-area {
        overflow-y: auto;
        max-height: 743px;
    }

    .chat-area {
        margin-top: 20px;
        display: block;
        border: 1px solid #ea1826;
        background-color: #ffffff;
        padding: 20px;
        height: 450px; /* Set a fixed height */
        width: auto;
        font-family: "Roboto", sans-serif;
        border-radius: 5px;
        overflow-y: scroll; /* Change overflow property */
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
        margin-top: 20px;
    }

    .chat-form input[type="text"] {
        width: calc(100% - 120px);
        border: 1px solid #ea1826;
        padding: 5px;
    }

    .chat-form button {
        width: 110px;
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
        <div class="col-xxl-4 col-xl-4 col-lg-4 mx-auo contact-page-form-area">
            <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                <span class="section-sub-title">All Messages</span>
            </div>
            <ul>
                <li>
                    <a>
                        <span>Sender1</span>
                        <span><i class="icon-arrow-right-double"></i></span>
                    </a>
                </li>
                <li>
                    <a>
                        <span>Sender2</span>
                        <span><i class="icon-arrow-right-double"></i></span>
                    </a>
                </li>
                <li>
                    <a>
                        <span>Sender3</span>
                        <span><i class="icon-arrow-right-double"></i></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-xxl-8 col-xl-8 col-lg-8 mx-auto"> 
            <div class="contact-page-form-area">
                <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                    <span class="section-sub-title">Inbox</span>
                    <div id="chatArea" class="chat-area">
                    <!-- Chat messages will be displayed here -->
                    </div>
                    <form id="chatForm" class="chat-form">
                        <input type="text" id="messageInput" placeholder="  Type your message...">
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
      