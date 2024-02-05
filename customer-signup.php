<?php
session_start(); 
include 'config/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = mysqli_real_escape_string($con,$_POST["fname"]);
    $lname = mysqli_real_escape_string($con,$_POST["lname"]);
    $phone = mysqli_real_escape_string($con,$_POST["phone"]);
    $addressNO = mysqli_real_escape_string($con,$_POST["add_no"]);
    $address1 = mysqli_real_escape_string($con,$_POST["address1"]);
    $address2 = mysqli_real_escape_string($con,$_POST["address2"]);
    $city = mysqli_real_escape_string($con,$_POST["city"]);
    $zipcode = mysqli_real_escape_string($con,$_POST["zipcode"]);
    $country = mysqli_real_escape_string($con,$_POST["country"]);
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $password = mysqli_real_escape_string($con,$_POST["password"]);

    // Check if email is already registered
    $checkEmailQuery = "SELECT * FROM customer WHERE email='$email'";
    $result = mysqli_query($con, $checkEmailQuery);

    if ($result) {
        // Check the number of rows only if the query was successful
        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            $_SESSION['error'] = "Email is already registered. Please use a different email.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the 'customer' table
            $insertQuery = "INSERT INTO customer (fname, lname, phone, add_no, address1, address2, city, zipcode, country, email, password) 
                            VALUES ('$fname', '$lname', '$phone', '$addressNO', '$address1', '$address2', '$city', '$zipcode', '$country', '$email', '$hashedPassword')";

            if (mysqli_query($con, $insertQuery)) {
                // Sign up successful
                $_SESSION['success'] = "Sign up successfully!";
            } else {
                // Sign up failed
                $_SESSION['error'] = "Error signing up. Please try again.";
            }
        }
    }
}

// Close the database connection
mysqli_close($con);
?>

<?php include('partials/header.php'); ?>

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
               <h2 class="breadcrumb__title">Sign Up</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="index.php">Home</a></span></li>
                        <li><span><a href="signup.php">Sign Up</a></span></li>
                        <li><span>Customer</span></li>
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
         <div class="col-xxl-8 col-xl-8 col-lg-8 mx-auto"> 
            <div class="contact-page-form-area">
               <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                  <span class="section-sub-title">Sign Up</span>
                  <h3 class="section-title mt-10">Sign Up as a Customer</h3>
               </div>
               <div class="contact-page-form">
                    <form method="post" id="customerForm" class="account-form">
                        <div class="row mb-10-none mt-20">
                            <div class="col-lg-6">
                                <label>First Name</label>
                                <input type="text" placeholder="First Name" name="fname" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Last Name</label>
                                <input type="text" placeholder="First Name" name="lname" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Phone</label>
                                <input type="text" placeholder="Phone" name="phone" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Address No</label>
                                <input type="text" placeholder="Address No" name="add_no" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Address 1</label>
                                <input type="text" placeholder="Address 1" name="address1" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Address 2</label>
                                <input type="text" placeholder="Address 2" name="address2" required>
                            </div>
                            <div class="col-lg-4">
                                <label>City</label>
                                <input type="text" placeholder="city" name="city" required>
                            </div>
                            <div class="col-lg-4">
                                <label>Zip Code</label>
                                <input type="text" placeholder="Zip Code" name="zipcode" required>
                            </div>
                            <div class="col-lg-4">
                                <label>Country</label>
                                <input type="text" placeholder="Country" name="country" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Email</label>
                                <input type="email" placeholder="Email" name="email" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="password" required>
                            </div>
                            
                            <div class="col-lg-12 form-group text-center mt-10">
                                <button  type="submit" class="primary-btn-1 btn-hover w-100">
                                    Sign Up &nbsp; | <i class="icon-right-arrow"></i>
                                    <span style="top: 147.172px; left: 108.5px;"></span>
                                </button>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="account-item mt-30">
                                    <label>Already Have An Account? <a href="signin.php" class="text-base">Sign In</a></label>
                                </div>
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