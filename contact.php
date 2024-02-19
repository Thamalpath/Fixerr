<?php
session_start();

// Include necessary files
include 'config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Basic form validation
    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        $_SESSION['error'] = "Please fill in all fields.";
    } else {
        // Insert data into the contact table
        $query = "INSERT INTO contact (name, email, phone, subject, message) VALUES ('$name', '$email', '$phone', '$subject', '$message')";
        $result = mysqli_query($con, $query);

        if ($result) {
            $_SESSION['success'] = "Message sent successfully!";
            header("Location: contact.php");
            exit();
        } else {
            $_SESSION['error'] = "Error occurred while sending your message. Please try again.";
            header("Location: contact.php");
            exit();
        }
    }
}
?>

<?php include('partials/header.php'); ?>

<main>
   
    <!-- Breadcrumb area start --> 
    <div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
        <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
        <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
        <div class="small-container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper p-relative">
                    <h2 class="breadcrumb__title">Faq</h2>
                    <div class="breadcrumb__menu">
                        <nav>
                            <ul>
                                <li><span><a href="index.php">Home</a></span></li>
                                <li><span>Faq</span></li>
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
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="contact-p-info-area">
                        <div class="contact-box">
                            <div class="icon-1">
                                <i class="fat fa-envelope"></i>
                            </div>
                            <div class="info">
                                <span>Make A quote</span>
                                <h4><a>info@fixerr.com</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="contact-page-form-area">
                    <div class="title-box mb-40 wow fadeInLeft"
                        data-wow-delay=".5s">
                        <span class="section-sub-title">LET’S TALK</span>
                        <h3 class="section-title mt-10">Let’s Get in Touch</h3>
                    </div>
                    <div class="contact-page-form">
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Your Name</label>
                                    <input type="text" name="name" placeholder="Your Name">
                                </div>
                                <div class="col-lg-6">
                                    <label>Your Email</label>
                                    <input type="email" name="email" placeholder="Your Email">
                                </div>
                                <div class="col-lg-6">
                                    <label>Your Phone</label>
                                    <input type="tel" name="phone" placeholder="Your Phone">
                                </div>
                                <div class="col-lg-6">
                                    <label>Subject</label>
                                    <input type="text" name="subject" placeholder="Subject">
                                </div>
                                <div class="col-lg-12">
                                    <label>Your Message</label>
                                    <textarea name="message" placeholder="Write Message"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="primary-btn-1 btn-hover">
                                        Send Now &nbsp; | <i class="icon-right-arrow"></i>
                                        <span style="top: 147.172px; left: 108.5px;"></span>
                                    </button>
                                </div>
                            </div>
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