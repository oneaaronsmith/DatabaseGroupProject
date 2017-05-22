<?php
// Check if user is already logged in.
if (isset($_COOKIE['role'])) {
    switch ($_COOKIE['role']){
        // Redirect based on role.
        case "ADMIN":
			$pageTitle = "Admin Changelog - Missouri Airlines";
			include("/var/www/html/group/CS3380GRP5/www/core/header.php");
			include("/var/www/html/group/CS3380GRP5/www/core/navbar.html");
			include("../changelog/changelogSearch.php");
			date_default_timezone_set('America/Chicago');
			$date = date('d M Y');
            break;
    }
}
else {
    // User is not logged in, redirect to login page.
    echo "<script>window.location = \"/group/CS3380GRP5/www/login\";</script>";
}
?>

<!-- Link to style sheet -->
<link href="/group/CS3380GRP5/www/style/adminStyles.css" rel="stylesheet">

<!--This page is meant for showing the changelog-->
<div id="admin-edit-page">
	<div class="page-header">
	<h1 id="header">All changes to the employee database are recorded<small><br>Time is recorded for US Central Timezone (Missouri)<br></small></h1>
	</div>
			<!--Set up the changelog container-->
			<div class='admin-changelog-container'>
				<div class='form-container'>
					<!-- A button will cause the table to be shown -->
					<button class='btn btn-primary btn-sm' name='show-changelog' id='log-button'>Show changelog</button>
				</div>
				
				<!--Initially, the table will be hidden from view-->
				<div class='form-container-b table-limit' id='show-form' style='display: none;'>
				<h4>Changelog</h4>
				<?php 
					//Include the database connection.
					include("../core/secure/databaseConfig.php");
					$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
					
					//Print an error if there is one.
					if(mysqli_connect_error())
							echo "Connection to database failed: " . mysqli_connect_error();
						
					//Choose the group database
					mysqli_query($conn, "USE" .  "CS3380GRP5");
					
					//Use the query to select changelog results.
					$result = mysqli_query($conn, "SELECT * FROM Changelog");
						
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
						
						mysqli_close($conn);
					
				?>
					<br><br>
					<h4>Search records:</h4>
					<!-- The second option is to search the employee table for a certain individual. -->
					<form action='adminChangelog.php' method='POST'>
						Search:<input type='text' name='search-part' value='<?php echo $date;?>'>
						<select name='search-type'>
							<option value='date_occurred'>Date</option>
							<option value='employee_ID'>Employee ID</option>
							<option value='first_name'>First Name</option>
							<option value='last_name'>Last Name</option>
							<option value='employee_id'>Action Type</option>
						</select>
						Limit Entries: <input type="number" name="entries" value=5>
						<input class='btn btn-primary btn-sm' type='submit' name='search-changelog' value='Search changelog'>
					</form>
					<br>
					<div class='btn btn-primary btn-sm cancel' id='cancel-show'>Close</div>
				</div>
					
					<!-- Include PHP for handling of search -->
					<?php changelogSearch();?>
					
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
				
				<!--Introduce a form button that can take the user back to the first admin page-->
				<div class="form-container">
					<form name='return-home' id='return-home' action='index.php'>
								<input class='btn btn-primary btn-sm' id='return-button' type='submit' value='Return'>
					</form>
					<hr>
				</div>
</div>
				
<?php
include("/var/www/html/group/CS3380GRP5/www/core/footer.html");
?>
