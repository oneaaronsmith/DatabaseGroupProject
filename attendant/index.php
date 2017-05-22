<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ATTENDANT":
			$pageTitle = "Attendant Home - Missouri Airlines";
			include("/var/www/html/group/CS3380GRP5/www/core/header.php");
			include("/var/www/html/group/CS3380GRP5/www/core/navbar.html");
			include("body.php");
			include("/var/www/html/group/CS3380GRP5/www/core/footer.html");
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>