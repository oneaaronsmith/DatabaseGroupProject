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

<link href="../../style/adminStyles.css" rel="stylesheet">

<!--Wrap content-->
<div id="admin-edit-page" class='col-xs-12 col-md-12 col-lg-12'>
			
			<!--Warn the admin what is about to happen-->
			<div class="page-header">
			<h1 id="header">Warning: All deletions are final.<small> <br>Deleted records may not be recovered.</small></h1>
			</div>

<?php		
	//Set variables for post results
	$id = $_POST['id'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$uname = $_POST['uname'];
	$email = $_POST['email'];
	$role = $_POST['role'];
	
	//Remind them of their sins
	echo "You are about to delete the following record: ";
	
	//Build the form.
	echo "<form action='employeeDelete.php' method='post'>
			<table>
				<th>employee_id</th><th>first_name</th><th>last_name</th><th>username</th><th>email</th><th>role</th>
				<tr>
					<td><input type='text' name='id' value='$id' readonly></td>
					<td><input type='text' name='fname' value='$fname' readonly></td>
					<td><input type='text' name='lname' value='$lname' readonly></td>
					<td><input type='text' name='uname' value='$uname' readonly></td>
					<td><input type='text' name='email' value='$email' readonly></td>
					<td><input type='text' name='role' value='$role' readonly></td>
				</tr>
			</table>
			<br> <input type='submit' name='confirm-delete' class='btn btn-primary btn-sm cancel' value='Confirm Deletion'>
		  </form>";
		  
	echo "<br>";
	
	echo "If you do not wish to continue you may return to the employee edit page.";
	
	//Give them a way out.
	echo "<form action='equipmentEdit.php' method='post'>
			<input type='submit' class='btn btn-primary btn-sm cancel' value='Cancel'>
		  </form>";

	//IF they decide to confirm the deletion, trigger delete code.
	if(isset($_POST['confirm-delete'])) {
		
		//Only need id to take them out.
		$id = $_POST['id'];
		
		include("../../core/secure/databaseConfig.php");
					$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
					
					if(mysqli_connect_error())
							echo "Connection to database failed: " . mysqli_connect_error();
						
					mysqli_query($conn, "USE" .  "CS3380GRP5");
						
					//Make the delete query.
					$result = mysqli_query($conn, "DELETE FROM Employee WHERE employee_id = '$id'");
					
					//Let them know what's up
					if($result == TRUE) {
						include('../../changelog/recordChange.php');
						record($conn,"Delete Employee","Administrator removed employee $id from the database");
						echo "<br>Deletion successful. Returning to employee edit page in ";
						echo "<span id='timer'>5</span>";
					}
					else{
						echo "<br>Deletion failed. Returning to employee edit page in ";
						echo "<span id='timer'>5</span>";
					}
					
					//Take us home, country road.
					include('countdown.html');
	}
?>


</div>

<?php
include("../../core/footer.html");
?>

