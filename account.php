<?php
session_start();

// Show successfully Signed-in Alert
if(isset($_SESSION['user_data']) && !isset($_SESSION['success_alert_displayed'])) {
    $user_data = $_SESSION['user_data'];

    // Show success alert using Notyf.js
    $_SESSION['success'] = "Sign in successfully!";
    $_SESSION['success_alert_displayed'] = true; // Mark success alert as displayed
} elseif(!isset($_SESSION['user_data'])) {
    // Redirect if not signed in
    header("Location: signin.php");
    exit();
}

// Include necessary files
include 'config/dbcon.php';

// Retrieve user data from session
$user_data = $_SESSION['user_data'];
$user_type = $_SESSION['user_type'];

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars($data);
}

// Function to pre-fill input fields
function preFillInput($key) {
    global $user_data;
    if(isset($user_data[$key])) {
        echo sanitize($user_data[$key]);
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $add_no = mysqli_real_escape_string($con, $_POST['add_no']);
    $address1 = mysqli_real_escape_string($con, $_POST['address1']);
    $address2 = mysqli_real_escape_string($con, $_POST['address2']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $zipcode = mysqli_real_escape_string($con, $_POST['zipcode']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update user data based on user type
    if ($user_type == 'customer') {
        $query = "UPDATE customer SET fname='$fname', lname='$lname', phone='$phone', add_no='$add_no', 
                  address1='$address1', address2='$address2', city='$city', zipcode='$zipcode', country='$country', 
                  email='$email' WHERE id=" . $user_data['id'];
    } elseif ($user_type == 'professional') {
        $profession = sanitize($_POST['profession']);
        $query = "UPDATE professional SET fname='$fname', lname='$lname', phone='$phone', add_no='$add_no', 
                  address1='$address1', address2='$address2', city='$city', zipcode='$zipcode', country='$country', 
                  profession='$profession', email='$email' WHERE id=" . $user_data['id'];
    }
    
    // Execute the query
    $result = mysqli_query($con, $query);
    
    // Check if the update was successful
    if ($result) {
        // Update session data with the newly fetched user data
        $updated_user_query = "SELECT * FROM $user_type WHERE id=" . $user_data['id'];
        $updated_user_result = mysqli_query($con, $updated_user_query);
        $updated_user_data = mysqli_fetch_assoc($updated_user_result);
        
        $_SESSION['user_data'] = $updated_user_data;
        $_SESSION['success'] = "Data updated successfully!";
        header("Location: account.php");
    } else {
        $_SESSION['error'] = "Error updating data. Please try again.";
    }
}
include 'partials/header.php';
?>

<style>
.text-base{
    color: #ea1826;
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
               <h2 class="breadcrumb__title">Account</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="index.php">Home</a></span></li>
                        <li><span>Account</span></li>
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
         <div class="col-xxl-10 col-xl-10 col-lg-10 mx-auto"> 
            <div class="contact-page-form-area">
               <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                  <span class="section-sub-title">Account</span>
                  <h3 class="section-title mt-10">Account Details</h3>
               </div>
               <div class="contact-page-form">
                    <form method="post" id="userForm" class="account-form">
                        <div class="row mb-10-none mt-20">
                            <div class="col-lg-6">
                                <label>First Name</label>
                                <input type="text" placeholder="First Name" name="fname" value="<?php preFillInput('fname'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Last Name</label>
                                <input type="text" placeholder="First Name" name="lname" value="<?php preFillInput('lname'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Phone</label>
                                <input type="text" placeholder="Phone" name="phone" value="<?php preFillInput('phone'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Address No</label>
                                <input type="text" placeholder="Address No" name="add_no" value="<?php preFillInput('add_no'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Address 1</label>
                                <input type="text" placeholder="Address 1" name="address1" value="<?php preFillInput('address1'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Address 2</label>
                                <input type="text" placeholder="Address 2" name="address2" value="<?php preFillInput('address2'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>City</label>
                                <input type="text" placeholder="city" name="city" value="<?php preFillInput('city'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Zip Code</label>
                                <input type="text" placeholder="Zip Code" name="zipcode" value="<?php preFillInput('zipcode'); ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Country</label>
                                <input type="text" placeholder="Country" name="country" value="<?php preFillInput('country'); ?>">
                            </div>
                            <?php if($user_type == 'professional'): ?>
                                <div class="col-lg-6">
                                    <label>Profession</label>
                                    <input type="text" placeholder="Profession" name="profession" value="<?php preFillInput('profession'); ?>"> 
                                </div>
                            <?php endif; ?>

                            <?php if($user_type == 'professional'): ?>
                                <div class="col-lg-12">
                                    <label>Email</label>
                                    <input type="email" placeholder="Email" name="email" value="<?php preFillInput('email'); ?>">
                                </div>
                            <?php else: ?>
                                <div class="col-lg-6">
                                    <label>Email</label>
                                    <input type="email" placeholder="Email" name="email" value="<?php preFillInput('email'); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="col-lg-12 form-group text-center mt-10">
                                <button type="submit" class="primary-btn-1 btn-hover w-100">
                                    Update &nbsp; | <i class="icon-right-arrow"></i>
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