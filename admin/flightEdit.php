<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Edit Flights - Missouri Airlines";
			include("../core/header.php");
			include("../core/navbar.html");
			include('../core/secure/databaseConfig.php');
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>
<!-- A page for the edit of flight records for CS3380 Group Project due 11/27/16 -Smith -->
<!-- Link to the admin style sheet -->
<link href="../style/adminStyles.css" rel="stylesheet">
		
		<!-- Make a container that will wrap the page content-->
		<div id="admin-edit-page">
			
			<!--Set header-->
			<div class="page-header">
			<h1 id="header">Flight Edit Page<small> <br>Please make a selection</small></h1>
			</div>
		
			<!--Make another container to hold all options-->
			<div class='admin-flight-container'>
			
				<!-- . . . . . OPTION 1: SHOW flight TABLE . . . . . . . . . . . . . . . .. . . -->
				<div class='form-container'>
					<!--Include a button for browsing the flight table-->
					<button id='flight-table-button' class='btn btn-primary btn-sm'>Show flight table</button>
				
					<!-- If the button is pressed, show the flight table -->
					<div class='form-container-b' id='show-form' style='display: none;'>
						<?php 	include("flights/showFlightTable.php"); 
								showFlightTable();	?>
						<div class='btn btn-primary btn-sm cancel' id='cancel-show'>Close table</div>
					</div>
				</div>
				<script>
						//These jQuery functions toggle whether the flight table will be hidden.
						$('#flight-table-button').click(function() {
								$('#show-form').toggle('hide');
						});
						$('#cancel-show').click(function() {
								$( "#show-form" ).toggle('hide');
						});
				</script>	
				<hr>
				
				<!-- . . . . . OPTION 2: ADD flight. . . . . . . . . . . . . . . . . . . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Add button for showing/hiding addition parameters -->
					<form action='flights/flightAdd.php' method='post'>
						<button class='btn btn-primary btn-sm' id='add-flight-button'>Add a flight</button>
					</form>
					
					<hr>
				</div>
				<!-- . . . . . . . . . . OPTION 3: UPDATE flight RECORD . . . . . . . . . . -->
				<div class='form-container'>
					<!--Make a button for toggling hidden options-->
					<button class='btn btn-primary btn-sm' id='update-flight-button'>Update a flight</button>
				
					<!-- The options are originally hidden in this div -->
					<div class='form-container-b' id='update-option' style='display: none;'>
						<br>
						Browse flight table:
						<br>
						<!-- This button toggles the view for the flight table -->
						<button class='btn btn-primary btn-sm btn-home' id='show-flight-table-update-button' style='margin-left: 0px;'>Show full flight table</button>
						<br>
						<div class='form-container-c' id='update-table' style='display: none;'>
							<!-- Include PHP for building the table that appends an update option -->
							<?php include("flights/showFlightTableUpdate.php");?>
							<button class='btn btn-sm cancel btn-primary btn-secondary' id='update-show'>Close table</button>
						</div>
						<br>
						Search flight table:
						<!-- This form will allow users to search flight table for a certain individual -->
						<form action='flightEdit.php' method='POST'>
							<input type='text' name='search-part'>
							<select name='search-type'>
								<option value='flight_number'>Flight Number</option>
								<option value='departure_city'>FROM</option>
								<option value='arrival_city'>TO</option>
								<option value='flight_date'>Date YYYY-MM-DD</option>
								<option value='flight_time'>Flight Time</option>
								<option value='arrival_time'>Arrival Time</option>
								<option value='crew_ID'>Crew ID</option>
								<option value='aircraft'>Plane Serial Number</option>
								<option value='price'>Price</option>
							</select>
							<input class='btn btn-primary btn-sm' type='submit' name='show-update-search-table' value='Search flight table'>
						</form>
						<button class='btn btn-primary btn-sm cancel' id='cancel-update'>Cancel</button>
					</div>
					
					<!-- Include PHP for handling search -->
					<?php include("flights/showFlightTableUpdateSearch.php");?>
					
				</div>
				<script>
						//The following jQuery functions toggle hidden div views
						$('#show-flight-table-update-button').click(function() {
								$('#update-table').toggle('hide');
						});
						$('#update-show').click(function() {
							$('#update-table').toggle('hide');
						});
						$('#search-update-show').click(function() {
							$('#search-update-table').toggle('hide');
						});
						$('#update-flight-button').click(function() {
								$( "#update-option" ).toggle('hide');
						});
						$('#cancel-update').click(function() {
								$( "#update-option" ).toggle('hide');
						});
				</script>	
				<hr>
				
				
				<!-- . . . . . . . . . . OPTION 4: DELETE flight RECORD . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Make a button for toggling options -->
					<button class='btn btn-primary btn-sm' id='delete-flight-button'>Delete a flight</button>
				
					<!-- The delete options are initially hidden in this div -->
					<div class='form-container-b' id='delete-option' style='display: none;'>
						<br>
						Browse flight table:
						<br>
						<!-- The first option is to show a full flight table -->
						<button class='btn btn-primary btn-sm' id='show-flight-table-delete-button'>Show full flight table</button>
						<br>
						<!-- The table is initially hidden -->
						<div class='form-container-c' id='delete-table' style='display: none;'>
							<!-- This PHP builds the delete table -->
							<?php include("flights/showFlightTableDelete.php");?>
							<button class='btn btn-sm cancel btn-primary btn-secondary' id='delete-show'>Close table</button>
						</div>
						<br>
						Search flight table:
						<!-- The second option is to search the flight table for a certain individual. -->
						<form action='flightEdit.php' method='POST'>
							<input type='text' name='search-part'>
							<select name='search-type'>
								<option value='flight_number'>Flight Number</option>
								<option value='departure_city'>FROM</option>
								<option value='arrival_city'>TO</option>
								<option value='flight_date'>Date YYYY-MM-DD</option>
								<option value='flight_time'>Flight Time</option>
								<option value='arrival_time'>Arrival Time</option>
								<option value='crew_ID'>Crew ID</option>
								<option value='aircraft'>Plane Serial Number</option>
								<option value='price'>Price</option>
							</select>
							<input class='btn btn-primary btn-sm' type='submit' name='show-delete-search-table' value='Search flight table'>
						</form>
						<button class='btn btn-primary btn-sm cancel' id='cancel-delete'>Cancel</button>
					</div>
					
					<!-- Include PHP for handling of search -->
					<?php 	include("flights/showFlightTableDeleteSearch.php");?>
					
				</div>
				<script>
						//These jQuery functions handle the toggle of hidden div options
						$('#show-flight-table-delete-button').click(function() {
								$('#delete-table').toggle('hide');
						});
						$('#delete-show').click(function() {
							$('#delete-table').toggle('hide');
						});
						$('#search-delete-show').click(function() {
							$('#search-delete-table').toggle('hide');
						});
						$('#delete-flight-button').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
						$('#cancel-delete').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
					</script>
					<hr>
				
				<!-- . . . . . . OPTION 5: ADD/Delete CREW . . . . . . . . . . . . . . . . . -->
					<div class='form-container'>
					<!-- Add button for showing/hiding addition parameters -->
					<form action='flights/crewEdit.php' method='post'>
						<button class='btn btn-primary btn-sm' id='add-crew-button'>Add/Delete Crew</button>
					</form>
					
					<hr>
				</div>
					<!-- . . . . . OPTION 5: RETURN TO ADMIN HOMEPAGE . . . . . . . . . .
					This form is purposed for returning the user to the admin homepage -->
					<div class='form-container'>
						<form name='return-home' id='return-home' action='../index.php'>
								<input class='btn btn-primary btn-sm btn-home' id='return-button' type='submit' value='Return to admin homepage'>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
include("../core/footer.html");
?>

