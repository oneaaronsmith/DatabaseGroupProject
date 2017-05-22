<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
            echo "<script>window.location = \"/group/CS3380GRP5/www/admin\";</script>";
            break;
        case "PILOT":
            echo "<script>window.location = \"/group/CS3380GRP5/www/pilot\";</script>";
            break;
        case "ATTENDANT":
            echo "<script>window.location = \"/group/CS3380GRP5/www/attendant\";</script>";
            break;
    }
}
else {
    // User is not logged in, show login page.
    $pageTitle = "Login - Missouri Air";
    include("/var/www/html/group/CS3380GRP5/www/core/header.php");
    include("/var/www/html/group/CS3380GRP5/www/core/navbar.html");
    include("body.php");
    include("/var/www/html/group/CS3380GRP5/www/core/footer.html");
}
?>
