<?php 
// Include configuration file  
require_once 'config.php'; 
// require_once 'object.php';
include 'config/dbcon.php';

session_start();

// Retrieve the order ID from the URL parameters
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

// Retrieve the service_id, service_name, price, and currency from the query parameters
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$service_name = isset($_GET['service_name']) ? urldecode($_GET['service_name']) : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$currency = isset($_GET['currency']) ? $_GET['currency'] : '';

// Set the session variables
$_SESSION['service_name'] = $service_name;
$_SESSION['price'] = $price;
$_SESSION['currency'] = $currency;
$_SESSION['order_id'] = $order_id;

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Gateway</title>

        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/logo/logo.png">

        <!-- Stripe JS library -->
        <script src="https://js.stripe.com/v3/"></script>
        <script src="assets/js/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>
    </head>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Berlin+Sans+FB:wght@300;400;500;600;700;800&display=swap");
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global styles */
        body {
            font-family: 'Berlin Sans FB', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .panel-heading {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .panel-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button styles */
        .btn {
            margin-top: 20px;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            background-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Spinner styles */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #333;
            animation: spin 1s linear infinite;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Hidden class */
        .hidden {
            display: none;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>

    <body>
        <div class="container">
            <h1>Stripe Payment Gateway Integration</h1>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Charge <?php echo '$'.$_SESSION['price']; ?> with Stripe</h3>
                    
                    <!-- Product Info -->
                    <p><b>Item Name:</b> <?php echo $_SESSION['service_name']; ?></p>
                    <p><b>Price:</b> <?php echo  ''.$_SESSION['price'].' '.$_SESSION['currency']; ?></p>
                </div>
                <div class="panel-body">
                    <!-- Display status message -->
                    <div id="paymentResponse" class="hidden"></div>
                    
                    <!-- Display a payment form -->
                    <form id="paymentFrm" class="hidden">
                        <div class="form-group">
                            <label>NAME</label>
                            <input type="text" id="name" class="field" placeholder="Enter name" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" id="email" class="field" placeholder="Enter email" required="">
                        </div>
                        
                        <div id="paymentElement">
                            <!--Stripe.js injects the Payment Element-->
                        </div>
                        
                        <!-- Form submit button -->
                        <button id="submitBtn" class="btn btn-success">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="buttonText">Pay Now</span>
                        </button>
                    </form>
                    
                    <!-- Display processing notification -->
                    <div id="frmProcess" class="hidden">
                        <span class="ring"></span> Processing...
                    </div>
                    
                    <!-- Display re-initiate button -->
                    <!-- <div id="payReinit" class="hidden">
                        <button class="btn btn-primary" onClick="window.location.href=window.location.href.split('?')[0]"><i class="rload"></i>Re-initiate Payment</button>
                    </div> -->
                </div>
            </div>
        </div>
    </body>
</html>
