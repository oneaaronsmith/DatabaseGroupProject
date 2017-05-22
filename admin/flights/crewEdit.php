<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Add or Delete Crew - Missouri Airlines";
			include("../../core/header.php");
			include("../../core/navbar.html");
			include('../../core/secure/databaseConfig.php');
			include('../employee/employeeFunctions.php');
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
		<h1 id="header">Add/Delete Crew<small><br>A crew will be assigned to flights according to service requirements</small></h1>
	</div>
		<!--. . . . . OPTION 1: SHOW AN ATTENDANT TABLE . . . . . . . . .-->
			<div class='form-container'>
				<!--Include a button for browsing the employee table-->
				<button id='attendant-table-button' class='btn btn-primary btn-sm'>Show attendants table</button>
			
				<!-- If the button is pressed, show the employee table -->
				<div class='form-container-b table-limit' id='show-attendant' style='display: none;'>
					<h4>Missouri Air Attendants List</h4>
					<?php printWholeTable("SELECT * FROM Employee INNER JOIN Attendant ON Employee.employee_ID = Attendant.employee_ID"); ?>
					<button class='btn btn-primary btn-sm cancel' id='cancel-attendant'>Close table</button>
				</div>
			</div>
			<script>
					//These jQuery functions toggle whether the employee table will be hidden.
					$('#attendant-table-button').click(function() {
							$('#show-attendant').toggle('hide');
					});
					$('#cancel-attendant').click(function() {
							$( "#show-attendant" ).toggle('hide');
					});
			</script>	
			<hr>
			
			<!-- . . . . . OPTION 2: SHOW A PILOT TABLE . . . . . . . . -->
			<div class='form-container'>
				<!--Include a button for browsing the employee table-->
				<button id='pilot-table-button' class='btn btn-primary btn-sm'>Show pilots table</button>
			
				<!-- If the button is pressed, show the employee table -->
				<div class='form-container-b table-limit' id='show-pilot' style='display: none'>
					<h4>Missouri Air Pilots List</h4>
					<?php printWholeTable("SELECT * FROM Employee INNER JOIN Pilot ON Employee.employee_ID = Pilot.employee_ID"); ?>
					<button class='btn btn-primary btn-sm cancel' id='cancel-pilot'>Close table</button>
				</div>
			</div>
			<script>
					//These jQuery functions toggle whether the employee table will be hidden.
					$('#pilot-table-button').click(function() {
							$('#show-pilot').toggle('hide');
					});
					$('#cancel-pilot').click(function() {
							$( "#show-pilot" ).toggle('hide');
					});
			</script>	
			<hr>
			
			<div class='form-container'>
				<!--Include a button for showing the table-->
				<button id='crew-table-button' class='btn btn-primary btn-sm'>Show crew table</button>
				<div class='form-container-b table-limit' id='show-crew' style='display: none'>
					<h4>Crews</h4>
					<?php include('../form_options/crewOptions.php'); ?>
				</div>
			</div>
			<script>	
					$('#crew-table-button').click(function() {
						$('#show-crew').toggle('hide');
					});
					$('#cancel-pilot').click(function() {
							$( "#show-crew" ).toggle('hide');
					});
			
			</script>
		<hr>
		<!--OPTION 3: Add a crew.-->
		<div class='form-container'>
			<!--The button to show-->
			<button id='add-crew-button' class='btn btn-primary btn-sm'>Add Crew</button>
			
			<!--Hidden div that shows when the people want it-->
			<div class='' id='show-crew-add' style='display: none;'>
				<h4>Add Crew</h4>
				<!-- Includes a button for showing pilot amounts -->
				Please select number of pilots and attendants:
				<form action='crewEdit.php' method='post'>
					<pre>
							Number of pilots:			<input type='number' name='numPilots'><br>
							Number of attendants:		<input type='number' name='numAttendants'><br>
							<input type='submit' class='btn btn-primary btn-sm' value='Submit Crew Numbers' name='numSubmit'>
					</pre>
				<form>
				<form action='crewEdit.php' method='post'>
			</div>
					<?php 
							include('handleCrewEdit.php');
							
							if(isset($_POST['numSubmit'])){
							printCrewChoices($_POST['numPilots'],$_POST['numAttendants']);
							}
							
							if(isset($_POST['crewSubmit'])){
							$numCrewPilots = $_POST['numPilots'];
							$numCrewAttendants = $_POST['numAttendants'];
							newCrew($numCrewPilots,$numCrewAttendants,$_POST['crewId']);
							}
					?>
					
				</form>	
			<hr>
		</div>
		<script>
				$('#add-crew-button').click(function() {
						$('#show-crew-add').toggle('hide');
				});
				$('#cancel-pilot').click(function() {
						$( "#show-crew-add" ).toggle('hide');
				});
		</script>
		
		<div class='form-container'>
			
			<button id='delete-crew-button' class='btn btn-primary btn-sm'>Delete Crew</button>
			
			<div class='' id='show-crew-delete' style='display: none;'>
				<h4>Delete Crew</h4>
				<!-- Includes a button for showing pilot amounts -->
				Please select the crew_ID you would like to delete:
				<form action='crewEdit.php' method='post'>
					<pre>
							Crew ID Number	<input type='number' name='deleteCrewId'>
							
							<input type='submit' class='btn btn-primary btn-sm' value='Submit For Deletion' name='deleteSubmit'>
					</pre>
				<form>
				<form action='crewEdit.php' method='post'>
			</div>
					<?php 
						if(isset($_POST['deleteSubmit'])) {
							deleteCrew($_POST['deleteCrewId']);
						}
					?>
				</form>
				
			<hr>
		</div>
		<script>
				$('#delete-crew-button').click(function() {
						$('#show-crew-delete').toggle('hide');
				});
				$('#cancel-pilot').click(function() {
						$( "#show-crew-delete" ).toggle('hide');
				});
		</script>
	<div class='form-container'>
		<form action='../flightEdit.php' method='post'>
			<input type='submit' class='btn btn-primary btn-sm cancel' value='Return'>
		</form>
	</div>


</div>

<?php
include("../../core/footer.html");
?>

