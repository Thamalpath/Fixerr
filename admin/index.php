<?php
session_start();

// Hardcoded username and password
$hardcoded_username = "admin";
$hardcoded_password = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are correct
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === $hardcoded_username && $password === $hardcoded_password) {
        $_SESSION['success'] = "Logged in successfully!";
        $_SESSION['logged_in'] = true; // Set session variable indicating successful login
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
  	<title>Admin Sign In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="login/css/style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(login/images/bg.jpg);">
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Admin Sign In</h2>
          </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form method="POST" class="signin-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group mb-4">
                        <input id="username" name="username" type="text" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="form-group mb-4">
                        <input id="password-field" name="password" type="password" class="form-control" placeholder="Password" required>
                        <!-- <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> -->
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                    </div>
                    <div class="form-group mt-5">
                      <button type="submit" class="form-control btn btn-primary submit px-3" onclick="redirectToHomePage()">Home Page</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </section>

	  <script src="login/js/jquery.min.js"></script>
    <script src="login/js/popper.js"></script>
    <script src="login/js/bootstrap.min.js"></script>
    <script src="login/js/main.js"></script>

    <script>
      function redirectToHomePage() {
        // Redirect to the home page
        window.location.href = '../index.php';
      }
    </script>

    <!-- Add this script to initialize Notyf.js -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const notyf = new Notyf({
        duration: 3000,
        position: {
          x: 'right',
          y: 'top',
        },
      });

      <?php
        // Display success or error alerts
        if (isset($_SESSION['success'])) {
              echo "notyf.success('{$_SESSION['success']}');";
              unset($_SESSION['success']); 
        }

        if (isset($_SESSION['error'])) {
              echo "notyf.error('{$_SESSION['error']}');";
              unset($_SESSION['error']); 
        }
      ?>
    </script>

	</body>
</html>

