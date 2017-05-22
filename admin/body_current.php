<!--This file is for use with admin/index.php It displays choices for what the admin can do.-->

<!--Link admin style sheet -->
<link href="/group/CS3380GRP5/www/style/adminStyles.css" rel="stylesheet">

<!--Wrapper div for home page-->
<div id='admin-home-page' class='col-xs-12 col-md-12 col-lg-12'>

	<!--Header for page message -->
	<div class='page-header'>
		<h1 id='header'>Welcome back, <?php echo $_COOKIE['firstName'];?><small><br>Please make a selection</small></h1>
	</div>

	<!--Make another container to hold all options-->
			<div class='admin-flight-container'>

				<!--First choice is to show monitor table-->
				<div class='form-container'>
					<!--Include a button for browsing the flight table-->
					<button id='monitor-table-button' class='btn btn-primary btn-sm'>Monitor flights</button>

					<!-- If the button is pressed, show the flight table -->
					<div class='form-container-b' id='show-form' style='display: none;'>
						<h4>Missouri Air Flights</h4>
						<?php 	include("flights/showFlightTable.php");
								showFlightTable();	?>
						<div class='btn btn-primary btn-sm cancel' id='cancel-show'>Close table</div>
					</div>
				</div>
				<script>
						//These jQuery functions toggle whether the flight table will be hidden.
						$('#monitor-table-button').click(function() {
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
			<form name='admin-changelog' id='admin-changelog' action='adminChangelog.php'>
				<input class='btn btn-primary btn-sm' id='admin-changelog-button' type='submit' value='Check change log'>
			</form>
		</div>
	</div>
	<hr>
	<!--Third choice is to edit employee record-->
	<div class='admin-employee-container'>
		<div class='form-container'>
			<form name='admin-employee' id='admin-employee' action='employee/employeeEdit.php'>
				<input class='btn btn-primary btn-sm' id='mployee-button' type='submit' value='Edit employee records'>
			</form>
				<span id='errorMessage'></span>
		</div>
	</div>
	<hr>
	<!--Fourth choice is to edit flight records-->
	<div class='admin-flight-container'>
		<div class='form-container'>
			<form name='admin-flight' id='admin-flight' action='flightEdit.php'>
				<input class='btn btn-primary btn-sm' id='flight-button' type='submit' value='Edit flight records'>
			</form>
		</div>
	</div>
	<hr>
	<!--Final choice is to edit equipment records-->
	<div class='admin-equip-container'>
		<div class='form-container'>
			<form name='admin-equip' id='admin-equip' action='equipmentEdit.php'>
				<input class='btn btn-primary btn-sm' id='equip-button' type='submit' value='Edit equipment records'>
			</form>
		</div>
	</div>
	<hr>

	<div class='logout-container'>
		<div class='form-container'>
			<form name='logout' id='logout' action='/group/CS3380GRP5/www/logout/logout.php'>
				<input class='btn btn-primary btn-sm' id='logout-button' type='submit' value='Logout'>
			</form>
		</div>
	</div>
</div>
