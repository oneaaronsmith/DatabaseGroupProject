<?php
//Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        //Redirect based on role.
        case "ATTENDANT":
			$pageTitle = "Attendant Home - Missouri Airlines";
			include("../core/header.php");
			include("../core/navbar.html");
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>

<link href="../style/adminStyles.css" rel="stylesheet">
	<div id="admin-edit-page">
		
			<div class="page-header">
				<h1 id="header">Update employee record<small><br>Employee identification number may not be changed</small></h1>
			</div>
<?php
	//This section of php is used alongside "employeeUpdate.php" and displays the attendant's information including all of their employee and attendant specific attributes.
	
	include('../core/secure/databaseConfig.php');
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
	
	//Announce error if there was an error
	if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
	
	$id = $_COOKIE['employeeId'];
	//Select all of the attendant's attributes from both the employee and attendant tables
	$result = mysqli_query($conn, "SELECT Employee.employee_ID,Employee.first_name,Employee.last_name,Employee.email_address,Employee.username,Attendant.status,Attendant.hours,Attendant.rank FROM Employee INNER JOIN Attendant ON Employee.employee_ID = Attendant.employee_ID AND Employee.employee_ID = '" . $id . "'");
		
		//Make an update form in which the user could change their information, excluding ID and role.
		echo "<div class='form-container'>
				<form action='attendantUpdate.php' method='post'>";
		echo "<br><table>";
		while($field = mysqli_fetch_field($result))
		{
			echo "<th>";
			echo $field->name . "<br>";
			echo "</th>\n";
		}
		
		while($row = mysqli_fetch_assoc($result))
		{
			echo "<tr>";
				echo "
					<td><input type='text' name='id' value='" . $row['employee_ID'] . "' readonly></td>
					<td><input type='text' name='fname' value='" . $row['first_name'] . "'></td>
					<td><input type='text' name='lname' value='" . $row['last_name'] . "'></td>
					<td><input type='text' name='email' value='" . $row['email_address'] . "'></td>
					<td><input type='text' name='uname' value='" . $row['username'] . "'></td>
					<td><input type='text' name='status' value='" . $row['status'] . "'></td>
					<td><input type='number' name='hours' value='" . $row['hours'] . "'></td>
					<td><input type='text' name='rank' value='" . $row['rank'] . "'></td> 
					</tr>\n";
		}
		echo "</table>";
		mysqli_close($conn);
		
		//Include a button through which the user would submit the form to the employeeUpdate.php
		echo"
		<input type='submit' name='confirm-update' class='btn btn-primary cancel btn-sm ' value='Update'>
		</form>
		</div>";
		  
		echo "<br><hr>";
?>
	
	
<?php
	/*This section of php is for handling the confirmation of an update by the user*/
	if(isset($_POST['confirm-update'])) {
	
		//Assign variables.
		$id = $_POST['id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$status = $_POST['status'];
		$hours = $_POST['hours'];
		$rank = $_POST['rank'];
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
			echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Update the tables with the new information
		$result1 = mysqli_query($conn, "UPDATE Employee SET first_name='$fname',last_name='$lname',username='$uname', email_address='$email' WHERE employee_ID = '$id'");
		$result2 = mysqli_query($conn, "UPDATE Attendant SET status='$status',hours='$hours',rank='$rank' WHERE employee_ID = '$id'");
		if($result1 == TRUE && $result2 == TRUE) {
			//Notify the changelog and print a success message
			include ('../changelog/recordChange.php');
			record($conn,"Employee Update","Attendant $id updated their personal information");
			echo "<br>Update successful.";
		}
		else if($result1 == TRUE && $result2 == FALSE)
		{
			echo "<br>Basic employee update successful. Attendant attributes update failed to update.";
		}
		else
		{
			echo "<br>Update failed.";
		}
	}
?>

<span><br>If you are finished or do not wish to alter your information, you may click return</span>
		
		<div class='form-container'>
			<form action='index.php' method='post'>
					<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
			</form>
		</div>
		
<?php
include("../core/footer.html");
?>
