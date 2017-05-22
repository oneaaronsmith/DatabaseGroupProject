<!--This file is for use with pilot/index.php It displays choices for what the pilot can do.-->
<?php include_once("../core/Authentication.php");?>
<!--Link pilot style sheet-->
<link href="../style/adminStyles.css" rel="stylesheet">

<!--Wrapper div for home page-->
<!--<div class='credential-check' style='visibility:hidden;'>-->

<div class='admin-edit-page'>
		<!--Header for page message -->
		<br>
		<br>
		<br>
		<br>
		<div class='page-header'>
			<h1 id='header'>Welcome back, <?php echo $_COOKIE['firstName'] . "!<br>";?><small>Please make a selection.</small></h1>
		</div>

	<!--First choice is to update their employee record-->
	<div class='pilot-employee-container'>
		<div class='form-container'>
			<form name='pilot-employee' id='pilot-employee' action='pilotUpdate.php'>
				<input class='btn btn-primary btn-sm' id='mployee-button' type='submit' value='Edit Profile'>
			</form>
				<span id='errorMessage'></span>
		</div>
	</div>
	<hr>
	<!--Fourth choice is to edit flight records
	<div class='pilot-flight-container'>
		<div class='form-container'>
			<form name='pilot-flight' id='pilot-flight' action='pastFlights.php'>
				<input class='btn btn-primary btn-sm' id='flight-button' type='submit' value='View Past Flights'>
			</form>
		</div>
	</div>
	<hr>-->
	
	<!--View past flight table-->
				<div class='form-container'>
					<!--Include a button for browsing the flight table-->
					<button id='past-table-button' class='btn btn-primary btn-sm'>View Past Flights</button>

					<!-- If the button is pressed, show the flight table -->
					<div class='form-container-b' id='show-form' style='display: none;'>
						<h4>Your Past Flights</h4>
						<?php 	include("pastFlights.php") ?>
						<div class='btn btn-primary btn-sm cancel' id='cancel-show'>Close table</div>
					</div>
				</div>
				<script>
						//These jQuery functions toggle whether the flight table will be hidden.
						$('#past-table-button').click(function() {
								$('#show-form').toggle('hide');
						});
						$('#cancel-show').click(function() {
								$( "#show-form" ).toggle('hide');
						});
				</script>
				<hr>
	
	<!--Second choice is to check the change log-->
	<div class='change-container'>
		<div class='form-container'>
			<form name='pilot-changelog' id='pilot-changelog' action='pilotChangelog.php'>
				<input class='btn btn-primary btn-sm' id='pilot-changelog-button' type='submit' value='View Change Log'>
			</form>
		</div>
	</div>
	<hr>

	<!-- Logout -->
	<div class='logout-container'>
		<div class='form-container'>
			<form name='logout' id='logout' action='/group/CS3380GRP5/www/logout/logout.php'>
				<input class='btn btn-primary btn-sm' id='logout-button' type='submit' value='Logout'>
			</form>
		</div>
	</div>
	<hr>
	
</div>

