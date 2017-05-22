<?php
$pageTitle = "Attendant - Changelog Page";
include("/var/www/html/group/CS3380GRP5/www/core/header.php");
include("/var/www/html/group/CS3380GRP5/www/core/navbar.html");
?>

<!-- Link to style sheet -->
<link href="../style/adminStyles.css" rel="stylesheet">

<!--This page is meant for showing the changelog-->
<div id="admin-edit-page">
	<div class="page-header">
	<h1 id="header">All changes to the database have been recorded<small> <br>Enjoy</small></h1>
	</div>
			<!--Set up the changelog container-->
			<div class='attendant-changelog-container'>
				<div class='form-container'>
					<!-- A button will cause the table to be shown -->
					<button class='btn btn-primary btn-sm' name='show-changelog' id='log-button'>Show changelog</button>
				</div>
				
				<!--Initially, the table will be hidden from view-->
				<div class='form-container-b' id='show-form' style='display: none;'>
				<?php
					//Include the database connection.
					include("../core/secure/databaseConfig.php");
					$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
					$currentEmployee = $_COOKIE['employeeId'];
					
					//Print an error if there is one.
					if(mysqli_connect_error())
							echo "Connection to database failed: " . mysqli_connect_error();
						
					//Choose the group database
					mysqli_query($conn, "USE" .  "CS3380GRP5");
					
					//Use the query to select changelog results.
					$result = mysqli_query($conn, "SELECT * FROM Changelog WHERE employee_ID = $currentEmployee");
						
						//Fill the table
						echo "<table>";
						while($field = mysqli_fetch_field($result))
						{
							echo "<th>";
							echo $field->name . "<br>";
							echo "</th>\n";
						}

						while($row = mysqli_fetch_row($result))
						{
							echo "<tr>";
							foreach($row as $value)
							{
								echo "<td>";
								echo $value . "<br>";
								echo "</td>\n";  
							}
							echo "</tr>\n";
						}
						
						echo "</table>";
						
						//Make a div button that can close the table.
						echo "<div class='btn btn-primary btn-sm cancel' id='cancel-show'>Close table</div>";
						mysqli_close($conn);
					
				?>
				</div>
				<script>
						//These jQuery functions handle the hide/show function for the changelog table
						$('#log-button').click(function() {
							$('#show-form').toggle('hide');
						});
						$('#cancel-show').click(function() {
								$( "#show-form" ).toggle('hide');
						});
				</script>	
				<hr>
				
				<!--Introduce a form button that can take the user back to the first attendant page-->
				<form name='return-home' id='return-home' action='index.php'>
							<input class='btn btn-primary btn-sm' id='return-button' type='submit' value='Return to attendant homepage'>
				</form>
				<hr>
</div>
				
<?php
include("/var/www/html/group/CS3380GRP5/www/core/footer.html");
?>
