<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Equipment Edit - Missouri Airlines";
			include("../core/header.php");
			include("../core/navbar.html");
			include('employee/employeeFunctions.php');
			include('../core/secure/databaseConfig.php');
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
		<h1 id="header">Equipment Edit Page<small> <br>Please make a selection</small></h1>
		</div>
	
		<div class='admin-equip-container'>
				<!-- . . . . . OPTION 1: SHOW EQUIPMENT TABLES . . . . . . . . . . . . . . . .. . . -->
				<div class='form-container'>
					<!--Include a button for browsing the equipment table-->
					<button id='equipment-table-button' class='btn btn-primary btn-sm'>Show equipment table</button>
				
					<!-- If the button is pressed, show the equipment table -->
					<div class='form-container-b' id='show-form' style='display: none; height:auto;'>
						<div class='col-md-12'>
							<div class='col-md-2 center'><h4>Current Fleet</h4>
								<?php include("equipment/showEquipment.php"); ?></div>
							<div class='col-md-10'><h4>Aircraft Descriptions</h4>
							<?php include("equipment/showEquipmentTypes.php"); ?></div>
						</div>
						<button class='btn btn-primary btn-sm cancel' id='cancel-show' style='width: 100px; margin-left: 28px;'>Close tables</button>
					</div>
				</div>
				<script>
						//These jQuery functions toggle whether the equipment table will be hidden.
						$('#equipment-table-button').click(function() {
								$('#show-form').toggle('hide');
						});
						$('#cancel-show').click(function() {
								$( "#show-form" ).toggle('hide');
						});
				</script>
				<hr>
				
				<!-- . . . . . OPTION 2: ADD EQUIPMENT. . . . . . . . . . . . . . . . . . . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Add button for showing/hiding addition parameters -->
					<button class='btn btn-primary btn-sm' id='add-equipment-button'>Add an equipment record</button>
					
					<!--Hidden form for adding equipments-->
					<div id='addition-container'>
						
						<pre style='margin-top: 20px;'>
							<form name='add' action='equipmentEdit.php' method='post'> <br>
									Equipment 		<select name='equipment' style='width: 150px; height: 25px;'>
																<?php include('form_options/equipmentOptions.php'); ?>
													<select><br>
									Identification		<input type='text' name='serial'>
									
													<input type='submit' class='btn btn-primary btn-sm' name='add-submit' value='Submit equipment addition'></form>
													<button class='btn btn-primary btn-sm cancel' style='margin-top: 0px;' id='cancel-add'>Cancel</button>
						</pre>
						
					</div>
					<br>
						<!--Include php for handling addition of equipment record addition-->
						<?php include("equipment/addEquipment.php"); ?>
					<script>
						//This script is for toggling the appearance of the hidden addition form
						$('#add-equipment-button').click(function() {
							$( "#addition-container" ).toggle('hide');
						});
						$('#cancel-add').click(function() {
								$( "#addition-container" ).toggle('hide');
						});
					</script>
					<hr>
				</div>
					<!-- . . . . . . . . . . OPTION 3: DELETE equipment RECORD . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Make a button for toggling options -->
					<button class='btn btn-primary btn-sm' id='delete-equipment-button'>Delete an equipment record</button>
				
					<!-- The delete options are initially hidden in this div -->
					<div class='form-container-b' id='delete-option' style='display: none;'>
						<br>
						Equipment table:
						<!-- This PHP builds the delete table -->
						<?php 	include("equipment/showEquipmentTableDelete.php");
								showEquipmentTableDelete();	?>
						<br>
						<div class='btn btn-primary btn-sm cancel' id='cancel-delete'>Close table</div>
					</div>
				</div>
				<script>
						//These jQuery functions handle the toggle of hidden div options
						$('#show-equipment-table-delete-button').click(function() {
								$('#delete-table').toggle('hide');
						});
						$('#delete-show').click(function() {
							$('#delete-table').toggle('hide');
						});
						$('#search-delete-show').click(function() {
							$('#search-delete-table').toggle('hide');
						});
						$('#delete-equipment-button').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
						$('#cancel-delete').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
				</script>
				<hr>
				
				<!--Give them the option to escape -->
				<div class='form-container'>
					<form action='index.php' method='post'>
						<input type='submit' class='btn btn-primary btn-sm' value='Return to Admin Homepage'>
					</form>
				</div>
				
		</div>
	</div>
		
<?php
include("../core/footer.html");
?>