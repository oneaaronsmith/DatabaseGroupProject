<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Update Flights - Missouri Airlines";
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

<link href="../../style/adminStyles.css" rel="stylesheet">

<!--Wrap all components-->
<div id="admin-edit-page">
			
			<!--Qwerky Greeting-->
			<div class="page-header">
			<h1 id="header">Update flight information<small><br></small></h1>
			</div>

<?php		
	//Set variables from the post that led user here.
	$flight_num = $_POST['flight_number'];
	$from = $_POST['departure_city'];
	$to = $_POST['arrival_city'];
	$date = $_POST['flight_date'];
	$time = $_POST['flight_time'];
	$arrival = $_POST['arrival_time'];
	$crew = $_POST['crew_ID'];
	$aircraft = $_POST['aircraft'];
	$price = $_POST['price'];
	$monday = $_POST['monday'];
	$tuesday = $_POST['tuesday'];
	$wednesday = $_POST['wednesday'];
	$thursday= $_POST['thursday'];
	$friday = $_POST['friday'];
	$saturday = $_POST['saturday'];
	$sunday = $_POST['sunday'];
	
	//Let user know whats up
	echo "You may update the following record: ";
	
	//Build form.
	echo "<div class='form-container'>
			<form action='flightUpdate.php' method='post'>
				<table>
					<th>flight_number</th><th>departure_city</th><th>arrival_city</th><th>flight_date</th>
					<th>flight_time</th><th>arrival_time</th><th>crew_ID</th><th>aircraft</th><th>price</th>
					<tr>
						<td><input type='text' name='flight_number' value='$flight_num' readonly></td>
						<td><input type='text' name='departure_city' value='$from'></td>
						<td><input type='text' name='arrival_city' value='$to'></td>
						<td><input type='text' name='flight_date' value='$date'></td>
						<td><input type='time' name='flight_time' value='$time'></td>
						<td><input type='time' name='arrival_time' value='$arrival'></td>
						<td><input type='text' name='crew_ID' value='$crew'></td>
						<td><input type='text' name='aircraft' value='$aircraft'></td>
						<td><input type='number' name='price' value='$price'></td>
					</tr>
					
					<th>monday</th><th>tuesday</th><th>wednesday</th><th>thursday</th><th>friday</th>
					<th>saturday</th><th>sunday</th>
					<tr>
						<td><input type='number' min='0' max='1' name='monday' value='$monday'></td>
						<td><input type='number' min='0' max='1' name='tuesday' value='$tuesday'></td>
						<td><input type='number' min='0' max='1' name='wednesday' value='$wednesday'></td>
						<td><input type='number' min='0' max='1' name='thursday' value='$thursday'></td>
						<td><input type='number' min='0' max='1' name='friday' value='$friday'></td>
						<td><input type='number' min='0' max='1' name='saturday' value='$saturday'></td>
						<td><input type='number' min='0' max='1' name='sunday' value='$sunday'></td>
					</tr>
				</table>
				<br> <input type='submit' name='confirm-update' class='btn btn-primary btn-sm cancel' value='Confirm Update'>
			  </form>
		  </div>";
		  
	echo "<br>";
	
	//Give the user a way to chicken out.
	echo "If you do not wish to continue you may return to the flight edit page.";
	
	echo "<div class='form-container'>
			<form action='../flightEdit.php' method='post'>
				<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
			</form>
		  </div>";
?>


<?php
	
	//If the user confirms the update. This code will trigger.
	if(isset($_POST['confirm-update'])) {
		
		//Get all the variables.
		$flight_num = $_POST['flight_number'];
		$from = $_POST['departure_city'];
		$to = $_POST['arrival_city'];
		$date = $_POST['flight_date'];
		$time = $_POST['flight_time'];
		$arrival = $_POST['arrival_time'];
		$crew = $_POST['crew_ID'];
		$aircraft = $_POST['aircraft'];
		$price = $_POST['price'];
		$monday = $_POST['monday'];
		$tuesday = $_POST['tuesday'];
		$wednesday = $_POST['wednesday'];
		$thursday= $_POST['thursday'];
		$friday = $_POST['friday'];
		$saturday = $_POST['saturday'];
		$sunday = $_POST['sunday'];
		
		//Remember the Alamo
		include("../../core/secure/databaseConfig.php");
		
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Make the query. (Could also use mysqli_prepare, but checking results quickly is easier this way)
		$result = mysqli_query($conn, "UPDATE Flights SET flight_number = $flight_num, departure_city = '$from' ,arrival_city = '$to', flight_date = '$date', flight_time = '$time', arrival_time = '$arrival', crew_ID = $crew, aircraft = '$aircraft', 
			price = $price, monday = $monday, tuesday = $tuesday, wednesday = $wednesday, thursday = $thursday, friday = $friday , saturday = $saturday , sunday = $sunday WHERE flight_number = $flight_num");
	
		//Let them know what happened.
		if($result == TRUE) {
			echo "<br>Update successful.";
			//echo "<span id='timer'>5</span>";
			include('../../changelog/recordChange.php');
			record($conn,"Flight Update","Administrator deleted flight $flight_num");
		}
		else{
			echo "<br>Update failed.";
			//echo "<span id='timer'>5</span>";
		}
		
		//Send them away with a countdown.
		//include('countdownFlight.html');
	}
?>


</div>

<?php
include("/var/www/html/group/CS3380GRP5/www/core/footer.html");
?>

