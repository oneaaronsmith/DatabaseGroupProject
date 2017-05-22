<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Delete Flight - Missouri Airlines";
			include("../../core/header.php");
			include("../../core/navbar.html");
			include('../../core/secure/databaseConfig.php');
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>

<!--Link style sheet-->
<link href="../../style/adminStyles.css" rel="stylesheet">

<!--Wrap all components in a div-->
<div id="admin-edit-page">
			
			<!--Give warning-->
			<div class="page-header">
			<h1 id="header">Warning: All deletions are final.<small> <br>Deleted records may not be recovered.</small></h1>
			</div>

<?php	
	//Employee should have pressed delete button to arrive here. So, prepare parameters based on post.
	$flight_num = $_POST['flight_number'];
	$from = $_POST['departure_city'];
	$to = $_POST['arrival_city'];
	$date = $_POST['flight_date'];
	$time = $_POST['flight_time'];
	$arrival = $_POST['arrival_time'];
	$crew = $_POST['crew_ID'];
	$aircraft = $_POST['aircraft'];
	$price = $_POST['price'];
	
	//Warn them again.
	echo "You are about to delete the following record: ";
	
	//Build the form to show them exactly what they will be missing.
	echo "<div class='form-container'>
			<form action='flightDelete.php' method='post'>
				<table>
					<th>flight_number</th><th>departure_city</th><th>arrival_city</th><th>flight_date</th>
					<th>flight_time</th><th>arrival_time</th><th>crew_ID</th><th>aircraft</th><th>price</th>
					<tr>
						<td><input type='text' name='flight_number' value='$flight_num' readonly></td>
						<td><input type='text' name='departure_city' value='$from' readonly></td>
						<td><input type='text' name='arrival_city' value='$to' readonly></td>
						<td><input type='text' name='flight_date' value='$date' readonly></td>
						<td><input type='text' name='flight_time' value='$time' readonly></td>
						<td><input type='text' name='arrival_time' value='$arrival' readonly></td>
						<td><input type='text' name='crew_ID' value='$crew' readonly></td>
						<td><input type='text' name='aircraft' value='$aircraft' readonly></td>
						<td><input type='text' name='price' value='$price' readonly></td>
					</tr>
				</table>
				<br> <input type='submit' name='confirm-delete' class='btn btn-primary btn-sm cancel' value='Confirm Deletion'>
			  </form>
		  </div>";
		  
	echo "<br>";
	
	//Give them a way out.
	echo "If you do not wish to continue you may return to the employee edit page.";
	
	echo "<div class='form-container'>
			<form action='../flightEdit.php' method='post'>
				<input type='submit' class='btn btn-primary btn-sm cancel' value='Cancel'>
			</form>
		  </div>";
		
?>


<?php
//If the admin confirms deletion, this code will trigger
	if(isset($_POST['confirm-delete'])) {
		
		//We only need the flight number.
		$flight_num = $_POST['flight_number'];
		
		//include("../../core/secure/databaseConfig.php");
		
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
		
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Make the deletion
		$result = mysqli_query($conn, "DELETE FROM Flights WHERE flight_number = $flight_num");
		
		//Let them know if it worked.
		if($result == TRUE) {
			echo "<br>Deletion successful. Returning to flight edit page in ";
			echo "<span id='timer'>5</span>";
		}
		else{
			echo "<br>Deletion failed. Returning to flight edit page in ";
			echo "<span id='timer'>5</span>";
		}
		
		//There will be no other actions to take. Return admin to previous page.
		include('countdownFlight.html');
	}
?>


</div>

<?php
include("../../core/footer.html");
?>

