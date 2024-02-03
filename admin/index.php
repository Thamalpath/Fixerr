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
            <form onsubmit="handleSignIn(event)" class="signin-form" action="">
              <div class="form-group mb-4">
                  <input id="username" type="text" class="form-control" placeholder="Username" required>
              </div>
              <div class="form-group mb-4">
                  <input id="password-field" type="password" class="form-control" placeholder="Password" required>
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
        // Initialize session
        session_start();
      ?>

      function handleSignIn(event) {
        event.preventDefault(); // Prevent default form submission

        // Hardcoded credentials
        const hardcodedUsername = 'admin';
        const hardcodedPassword = 'admin';

        // Retrieve user input
        const enteredUsername = document.getElementById('username').value;
        const enteredPassword = document.getElementById('password-field').value;

        // Check credentials
        if (enteredUsername === hardcodedUsername && enteredPassword === hardcodedPassword) {
          // Successful sign-in
          notyf.success('Sign-in successful!');
          setTimeout(() => {
            window.location.href = 'home.php';
          }, 1500);
        } else {
          // Failed sign-in
          notyf.error('Invalid credentials. Please try again.');
        }
      }
    </script>

	</body>
</html>

