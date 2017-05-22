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
			include('../../core/secure/databaseConfig.php');
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>

<!-- A page for the edit of employee records for CS3380 Group Project due 11/27/16 -Smith -->
<!-- Link to the admin style sheet 
<link href="../style/main.css" rel="stylesheet">-->
<link href="../../style/adminStyles.css" rel="stylesheet">

		<!-- Make a container that will wrap the page content-->
		<div id="admin-edit-page">
			
			<!--Set header-->
			<div class="page-header">
				<h1 id="header">Employee Edit Page<small><br>Please make a selection</small></h1>
			</div>
		
			<!--Make another container to hold all options-->
			<div class='admin-employee-container'>
			
				<!-- . . . . . OPTION 1: SHOW EMPLOYEE TABLE . . . . . . . . . . . . . . . .. . . -->
				<div class='form-container'>
					<!--Include a button for browsing the employee table-->
					<button id='employee-table-button' class='btn btn-primary btn-sm'>Show employee table</button>
				
					<!-- If the button is pressed, show the employee table -->
					<div class='form-container-b table-limit' id='show-form' style=''>
						<h4>Missouri Air Employee List</h4>
						<?php printWholeTable("SELECT * FROM Employee ORDER BY role"); ?>
						<button class='btn btn-primary btn-sm cancel' id='cancel-show'>Close table</button>
					</div>
				</div>
				<script>
						//These jQuery functions toggle whether the employee table will be hidden.
						$('#employee-table-button').click(function() {
								$('#show-form').toggle('hide');
						});
						$('#cancel-show').click(function() {
								$( "#show-form" ).toggle('hide');
						});
				</script>	
				<hr>
				
				<!--. . . . . OPTION 2: SHOW AN ATTENDANT TABLE . . . . . . . . .-->
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
				
				<!-- . . . . . OPTION 3: SHOW A PILOT TABLE . . . . . . . . -->
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
				<!-- . . . . . OPTION 4: ADD EMPLOYEE. . . . . . . . . . . . . . . . . . . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Add button for showing/hiding addition parameters -->
					<button class='btn btn-primary btn-sm' id='add-employee-button'>Add an employee record</button>
					
					<!--Hidden form for adding employees-->
					<div id='addition-container'>
						<form name='add' action='employeeEdit.php' method='post'> <br>
							<pre>
							First Name	<input type='text' name='first_name'><br>
							Last Name	<input type='text' name='last_name'><br>
							Username	<input type='text' name='user_name'><br>
							Email		<input type='text' name='email'><br>
							Role 		<select name='role'>
											<option value="ADMIN">Administrator</option>
											<option value="PILOT">Pilot</option>
											<option value="ATTENDANT">Attendant</option>
										</select><br>
										<input type='submit' class='btn btn-primary btn-sm' name='add-submit' value='Submit employee addition'><br>
										<button class='btn btn-primary btn-sm cancel' id='cancel-add'>Cancel</button>
							</pre>
							<br>
						</form>
					</div>
					<br>
						<!--Include php for handling addition of employee record addition-->
						<?php include("addEmployee.php"); ?>
					<script>
						//This script is for toggling the appearance of the hidden addition form
						$('#add-employee-button').click(function() {
							$( "#addition-container" ).toggle('hide');
						});
					
						$('#cancel-add').click(function() {
								$( "#addition-container" ).toggle('hide');
						});
					</script>
					<hr>
				</div>
				<!-- . . . . . . . . . . OPTION 5: UPDATE EMPLOYEE RECORD . . . . . . . . . . -->
				<div class='form-container'>
					<!--Make a button for toggling hidden options-->
					<button class='btn btn-primary btn-sm' id='update-employee-button'>Update an employee record</button>
				
					<!-- The options are originally hidden in this div -->
					<div class='form-container-b table-limit' id='update-option' style='display: none;'>
						<br>
						Browse employee table:
						<br>
						<!-- This button toggles the view for the employee table -->
						<button class='btn btn-primary btn-sm btn-home' id='show-employee-table-update-button' style='margin-left: 0px;'>Show full employee table</button>
						<br>
						<div class='form-container-c' id='update-table' style='display: none;'>
							<!-- Include PHP for building the table that appends an update option -->
							<?php showEmployeeUpdate();?>
							<button class='btn btn-sm cancel btn-primary btn-secondary' id='update-show'>Close table</button>
						</div>
						<br>
						Search employee table:
						<!-- This form will allow users to search employee table for a certain individual -->
						<form action='employeeEdit.php' method='POST'>
							<input type='text' name='search-part'>
							<select name='search-type'>
								<option value='first_name'>First Name</option>
								<option value='last_name'>Last Name</option>
								<option value='employee_id'>Employee Id</option>
								<option value='username'>Username</option>
								<option value='role'>Role</option>
							</select>
							<input class='btn btn-primary btn-sm' type='submit' name='show-search-table' value='Search employee table'>
						</form>
						<button class='btn btn-primary btn-sm cancel' id='cancel-update'>Cancel</button>
					</div>
					
					<!-- Include PHP for handling search -->
					<?php showEmployeeUpdateSearch();?>
					
				</div>
				<script>
						//The following jQuery functions toggle hidden div views
						$('#show-employee-table-update-button').click(function() {
								$('#update-table').toggle('hide');
						});
						$('#update-show').click(function() {
							$('#update-table').toggle('hide');
						});
						$('#search-update-show').click(function() {
							$('#search-update-table').toggle('hide');
						});
						$('#update-employee-button').click(function() {
								$( "#update-option" ).toggle('hide');
						});
						$('#cancel-update').click(function() {
								$( "#update-option" ).toggle('hide');
						});
				</script>	
				<hr>
				
				
				<!-- . . . . . . . . . . OPTION 6: DELETE EMPLOYEE RECORD . . . . . . . . . . -->
				<div class='form-container'>
					<!-- Make a button for toggling options -->
					<button class='btn btn-primary btn-sm' id='delete-employee-button'>Delete an employee record</button>
				
					<!-- The delete options are initially hidden in this div -->
					<div class='form-container-b table-limit' id='delete-option' style='display: none;'>
						<br>
						Browse employee table:
						<br>
						<!-- The first option is to show a full employee table -->
						<button class='btn btn-primary btn-sm' id='show-employee-table-delete-button'>Show full employee table</button>
						<br>
						<!-- The table is initially hidden -->
						<div class='form-container-c' id='delete-table' style='display: none;'>
							<!-- This PHP builds the delete table -->
							<?php showEmployeeDelete();?>
							<button class='btn btn-sm cancel btn-primary btn-secondary' id='delete-show'>Close table</button>
						</div>
						<br>
						Search employee table:
						<!-- The second option is to search the employee table for a certain individual. -->
						<form action='employeeEdit.php' method='POST'>
							<input type='text' name='search-part'>
							<select name='search-type'>
								<option value='first_name'>First Name</option>
								<option value='last_name'>Last Name</option>
								<option value='employee_id'>Employee Id</option>
								<option value='username'>Username</option>
								<option value='role'>Role</option>
							</select>
							<input class='btn btn-primary btn-sm' type='submit' name='show-delete-search-table' value='Search employee table'>
						</form>
						<button class='btn btn-primary btn-sm cancel' id='cancel-delete'>Cancel</button>
					</div>
					
					<!-- Include PHP for handling of search -->
					<?php showEmployeeDeleteSearch();?>
					
				</div>
				<script>
						//These jQuery functions handle the toggle of hidden div options
						$('#show-employee-table-delete-button').click(function() {
								$('#delete-table').toggle('hide');
						});
						$('#delete-show').click(function() {
							$('#delete-table').toggle('hide');
						});
						$('#search-delete-show').click(function() {
							$('#search-delete-table').toggle('hide');
						});
						$('#delete-employee-button').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
						$('#cancel-delete').click(function() {
								$( "#delete-option" ).toggle('hide');
						});
					</script>
					<hr>
					
					<!-- . . . . . OPTION 5: RETURN TO ADMIN HOMEPAGE . . . . . . . . . .
					This form is purposed for returning the user to the admin homepage -->
					<div class='form-container'>
						<form name='return-home' id='return-home' action='../index.php'>
								<input class='btn btn-primary btn-sm' id='return-button' type='submit' value='Return to admin homepage'>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
include("../../core/footer.html");
?>

