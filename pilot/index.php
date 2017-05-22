<?php
//Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        //Redirect based on role.
        case "PILOT":
			$pageTitle = "Pilot Home - Missouri Airlines";
			include("../core/header.php");
			include("../core/navbar.html");
			include("body.php");
			include("../core/footer.html");
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>