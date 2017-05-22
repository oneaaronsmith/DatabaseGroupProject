<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Home - Missouri Airlines";
			include("../../core/header.php");
			include("../../core/navbar.html");
			include('employeeFunctions.php');
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>

<link href="/group/CS3380GRP5/www/style/adminStyles.css" rel="stylesheet">

<div id="admin-edit-page">
		
			<div class="page-header">
			<h1 id="header">Update employee record<small><br>Employee identification number may not be changed</small></h1>
			</div>
<?php							
	$id = $_POST['id'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$uname = $_POST['uname'];
	$email = $_POST['email'];
	$role = $_POST['role'];
	
	echo "<h4>You may update the following record: </h4>";
	
	if($role == 'PILOT') {
		include('pilotUpdate.php');
	}
	else if($role == 'ATTENDANT') {
		include('attendantUpdate.php');
	}
	else if($role == 'ADMIN'){
		include('adminUpdate.php');
	}
	else{
		echo "Did something terrible happen? You really shouldn't still be here. Go back before it is too late.";
	}
?>
</div>

<?php
include("../../core/footer.html");
?>

