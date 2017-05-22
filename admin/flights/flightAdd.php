<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Edit Flights - Missouri Airlines";
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

<div id="admin-edit-page">
		
	<div class="page-header">
	<h1 id="header">Add a Flight<small><br>Flights will be searched for by customers.</small></h1>
	</div>
		<!--We start the form up here. But you're in for the long haul my friend-->
		<div>
		<form action='flightAdd.php' method='post'>
			<div>
				<h4>Designate arrival and departure city. Do not choose the same city.</h4>
				<pre>
							FROM	<select name='departure_city'>
										<?php include('../form_options/cityOptions.php'); ?>
									</select>
				<br>
							TO		<select name='arrival_city'>
										<?php include('../form_options/cityOptions.php'); ?>
									</select>
				</pre>
			</div>
			<hr>
			<div>
				<h4>Choose Flight Days</h4>
				<pre>
				<!--DATE	<input type='date' name='date'>-->
							<input type='checkbox' name='Monday'> Monday
							<input type='checkbox' name='Tuesday'> Tuesday
							<input type='checkbox' name='Wednesday'> Wednesday
							<input type='checkbox' name='Thursday'> Thursday
							<input type='checkbox' name='Friday'> Friday
							<input type='checkbox' name='Saturday'> Saturday
							<input type='checkbox' name='Sunday'> Sunday
				</pre>
			</div>
			<hr>
			<div>
				<h4>Choose which plane will make the flight</h4>
				<div class='form-container-b'>
					<?php include('../form_options/planeOptions.php'); ?>
				</div>
			</div>
			<hr>
			<div>
				<div class='form-container-b'>
					<h4>Choose an employee crew</h4>
					<?php include('../form_options/crewOptions.php'); ?>
					<br>Crew Choice: <input type='number' min='1' name='crew_ID'><br> (Keep in mind the crew must meet service requirements of chosen aircraft)
				</div>
				
				
			</div>
			<hr>
			<div>
				<h3>Designate departure and arrival times</h3>
				<pre>
							DEPART TIME	<input type='text' name='flight_time'><br>
							ARRIVE TIME	<input type='text' name='arrival_time'>
				</pre>
			</div>
			<hr>
			<div>
				<h3>Set price</h3>
				<pre>
							Price		<input type='number' name='price'>
				</pre>
			</div>
			<hr>
		
			<input type='submit' name='confirm-addition' class='btn btn-primary btn-sm cancel' value='Confirm Addition'>
		</form>
		</div>
	<br>	

	<div class='form-container'>
		<form action='../flightEdit.php' method='post'>
			<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
		</form>
	</div>


<?php
	include('../form_options/handleFlightAdd.php');
	handleFlightAdd();
?>

</div>

<?php
include("../../core/footer.html");
?>

