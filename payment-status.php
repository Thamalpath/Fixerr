<?php 
session_start();
// Include the configuration file  
require_once 'config.php'; 
 
// Include the database connection file  
require_once 'config/dbcon.php'; 
 
$payment_ref_id = $statusMsg = ''; 
$status = 'error'; 
 
// Check whether the payment ID is not empty 
if(!empty($_GET['pid'])){ 
    $payment_txn_id  = base64_decode($_GET['pid']); 
     
    // Fetch transaction data from the database 
    $sqlQ = "SELECT id,txn_id,paid_amount,paid_amount_currency,payment_status,customer_name,customer_email,order_id FROM transactions WHERE txn_id = ?"; 
    $stmt = $con->prepare($sqlQ);  
    $stmt->bind_param("s", $payment_txn_id); 
    $stmt->execute(); 
    $stmt->store_result(); 
 
    if($stmt->num_rows > 0){ 
        // Get transaction details 
        $stmt->bind_result($payment_ref_id, $txn_id, $paid_amount, $paid_amount_currency, $payment_status, $customer_name, $customer_email, $order_id); 
        $stmt->fetch(); 
         
        $status = 'success'; 
        $statusMsg = 'Your Payment has been Successful!'; 
    }else{ 
        $statusMsg = "Transaction has been failed!"; 
    } 
}else{ 
    header("Location: pay.php"); 
    exit; 
} 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Status</title>

        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/logo/logo.png">
    </head>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Berlin+Sans+FB:wght@300;400;500;600;700;800&display=swap");
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        p{
            font-size: 20px;
        }

        h3{
            font-size: 30px;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        /* Global styles */
        body {
            font-family: 'Berlin Sans FB', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            color: #5BB318;
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

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>

    <body>
        <div class="container">
            <div class="panel">
                <div class="panel-heading">
                    <?php if(!empty($payment_ref_id)){ ?>
                        <h1 class="<?php echo $status; ?>"><?php echo $statusMsg; ?></h1>
                </div>

                <div class="panel-body">
                    <h3>Payment Information<hr></h3>
                    
                    <p><b>Reference Number:</b> <?php echo $payment_ref_id; ?></p>
                    <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
                    <p><b>Order ID:</b> <?php echo $order_id; ?></p>
                    <p><b>Paid Amount:</b> <?php echo $paid_amount.' '.$paid_amount_currency; ?></p>
                    <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
                    
                    <h3>Customer Information<hr></h3>
                    <p><b>Name:</b> <?php echo $customer_name; ?></p>
                    <p><b>Email:</b> <?php echo $customer_email; ?></p>
                    
                    <h3>Service Information<hr></h3>
                    <p><b>Service Name:</b> <?php echo $_SESSION['service_name']; ?></p>
                    <p><b>Service Price:</b> <?php echo $_SESSION['price'].' '.$_SESSION['currency']; ?></p>
                <?php }else{ ?>
                    <h1 class="error">Your Payment been failed!</h1>
                    <p class="error"><?php echo $statusMsg; ?></p>
                <?php } ?>
            </div>
        </div>
    </body>
</html>