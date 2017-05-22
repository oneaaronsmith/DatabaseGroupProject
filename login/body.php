<div id="login-container">
    <h2>Login</h2>
  <form name="login" id="login-form" action="" method="POST">
    <span class="label">Employee ID</span><br>
    <input type="text" name="employeeId"><br>
    <span class="label">Password</span><br>
    <input type="password" name="password"><br>
    <span id="errorMessage"></span>
    <input class="btn btn-primary btn-sm" id="submit-button" type="submit" name="submit" value="Log In">
  </form>
</div>

<?php
include("/var/www/html/group/CS3380GRP5/www/core/Authentication.php");

// Initialize login process on form submit.
if (isset($_POST['submit'])) {
	// Hash password.
	$password = hash("SHA256", $_POST['password']);
	$password = hash("SHA512", $password);

    // Attempt to authenticate user with supplied credentials.
	$role = Authentication::login($_POST['employeeId'], $password);
    if ($role != FALSE) {
		// Determine Redirect page.
		switch ($role) {
			case "ADMIN":
				echo "<script>window.location = \"/group/CS3380GRP5/www/admin\";</script>";
				break;
			case "ATTENDANT":
				echo "<script>window.location = \"/group/CS3380GRP5/www/attendant\";</script>";
				break;
			case "PILOT":
				echo "<script>window.location = \"/group/CS3380GRP5/www/pilot\";</script>";
				break;
		}
    }
    else {
        // Display error message on unsuccessful login.
    	echo "<script>document.getElementById(\"errorMessage\").innerHTML = \"   Employee ID or password incorrect.\"</script>";
    }
}
