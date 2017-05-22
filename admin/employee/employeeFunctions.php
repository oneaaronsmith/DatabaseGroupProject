<?php
	//This function can be used to print entire tables based on a select statement independent of table type. . . . . . . . . . . . . . . .
	function printWholeTable($query) {
		//Connect to database
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		//Announce error if there was one.
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
			
		//Choose the group database
		mysqli_query($conn, "USE" .  "CS3380GRP5");
		
		//Make the query
		$result = mysqli_query($conn, $query);
		
		//Begin table
		echo "<table>";
		
		//Include headers
		while($field = mysqli_fetch_field($result))
		{
			echo "<th>";
			echo $field->name . "<br>";
			echo "</th>\n";
		}
		
		//Include table data
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
		
		//Close the table
		echo "</table>";

		//Close the connection
		mysqli_close($conn);
	}
	
	//This function prints a full employee table and adds an option to delete them. . . . . . . . . . . . . . . . . . . . . . . . . 
	function showEmployeeDelete() {
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
			
		$result = mysqli_query($conn, "SELECT employee_ID,first_name,last_name,email_address,username,role FROM Employee ORDER BY role");
			
			echo "<table>";
			while($field = mysqli_fetch_field($result))
			{
				echo "<th>";
				echo $field->name . "<br>";
				echo "</th>\n";
			}
			
			echo "<th>Choice</th>";

			while($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
					echo "<td>";
					echo $row['employee_ID'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['first_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['last_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['email_address'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['username'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['role'] . "<br>";
					echo "</td>\n";  
				
					echo "<td>";
					echo 	"<form action='employeeDelete.php' method='post'>
								<input type='hidden' name='id' value='" . $row['employee_ID'] . "'>
								<input type='hidden' name='fname' value='" . $row['first_name'] . "'>
								<input type='hidden' name='lname' value='" . $row['last_name'] . "'>
								<input type='hidden' name='uname' value='" . $row['username'] . "'>
								<input type='hidden' name='email' value='" . $row['email_address'] . "'>
								<input type='hidden' name='role' value='" . $row['role'] . "'>
								<input type='submit' name='submit-edit' value='delete'>
							</form>";
					echo "</td>";
					
				echo "</tr>\n";
			}
			echo "</table>";
			
			mysqli_close($conn);
	}
	
	//The delete search function builds a table with a delete button based on a search chosen by the admin.
	//This function must be used with the employeeEdit.php page since it references the specific id's
	function showEmployeeDeleteSearch() {
		//Only trigger if user submits a search.
		if(isset($_POST['show-delete-search-table'])) {
		
			//Make a div to hold the table.
			echo "<div class='form-container-b' id='search-delete-table'>";
			
			$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
			
			//Set up the search parameters
			$searchtype = $_POST['search-type'];
			$searchpart = $_POST['search-part'] . "%";
			
			if(mysqli_connect_error())
					echo "Connection to database failed: " . mysqli_connect_error();
				
			mysqli_query($conn, "USE" .  "CS3380GRP5");
			
			//Make query
			$result = mysqli_query($conn, "SELECT employee_id,first_name,last_name,email_address,username,role FROM Employee WHERE $searchtype LIKE '$searchpart' ORDER BY role");
				
				//Build the table
				echo "<table>";
				while($field = mysqli_fetch_field($result))
				{
					echo "<th>";
					echo $field->name . "<br>";
					echo "</th>\n";
				}
				
			echo "<th>Choice</th>";

			while($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
					echo "<td>";
					echo $row['employee_id'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['first_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['last_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['email_address'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['username'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['role'] . "<br>";
					echo "</td>\n";  
				
					//Include delete button and hidden inputs that can be passed to employeeDelete.php
					echo "<td>";
					echo 	"<form action='employeeDelete.php' method='post'>
								<input type='hidden' name='id' value='" . $row['employee_id'] . "'>
								<input type='hidden' name='fname' value='" . $row['first_name'] . "'>
								<input type='hidden' name='lname' value='" . $row['last_name'] . "'>
								<input type='hidden' name='uname' value='" . $row['username'] . "'>
								<input type='hidden' name='email' value='" . $row['email_address'] . "'>
								<input type='hidden' name='role' value='" . $row['role'] . "'>
								<input type='submit' name='submit-edit' value='delete'>
							</form>";
					echo "</td>";
					
				echo "</tr>\n";
			}
			
			echo "</table>";
			
			//Give users a way out.
			echo "<div class='btn btn-primary btn-sm cancel' id='search-delete-show'>Close table</div>";
			mysqli_close($conn);
			echo "</div>";
		}
	}
	
	function showEmployeeUpdate() {
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
		
		if(mysqli_connect_error())
				echo "Connection to database failed: " . mysqli_connect_error();
			
		mysqli_query($conn, "USE" .  "CS3380GRP5");
			
		$result = mysqli_query($conn, "SELECT employee_id,first_name,last_name,email_address,username,role FROM Employee ORDER BY role");
			
			echo "<table>";
			while($field = mysqli_fetch_field($result))
			{
				echo "<th>";
				echo $field->name . "<br>";
				echo "</th>\n";
			}
			
			echo "<th>Choice</th>";

			while($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
					echo "<td>";
					echo $row['employee_id'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['first_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['last_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['email_address'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['username'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['role'] . "<br>";
					echo "</td>\n";  
				
					echo "<td>";
					echo 	"<form action='employeeUpdate.php' method='post'>
								<input type='hidden' name='id' value='" . $row['employee_id'] . "'>
								<input type='hidden' name='fname' value='" . $row['first_name'] . "'>
								<input type='hidden' name='lname' value='" . $row['last_name'] . "'>
								<input type='hidden' name='uname' value='" . $row['username'] . "'>
								<input type='hidden' name='email' value='" . $row['email_address'] . "'>
								<input type='hidden' name='role' value='" . $row['role'] . "'>
								<input type='submit' name='submit-edit' value='Update'>
							</form>";
					echo "</td>";
					
				echo "</tr>\n";
			}
			
			echo "</table>";
			mysqli_close($conn);
	
	}
	
	
	function showEmployeeUpdateSearch() {
		if(isset($_POST['show-search-table'])) {
			echo "<div class='form-container-b' id='search-update-table'>";
			$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
			
			$searchtype = $_POST['search-type'];
			$searchpart = $_POST['search-part'] . "%";
			
			if(mysqli_connect_error())
					echo "Connection to database failed: " . mysqli_connect_error();
				
			mysqli_query($conn, "USE" .  "CS3380GRP5");
			
			$result = mysqli_query($conn, "SELECT employee_id,first_name,last_name,email_address,username,role FROM Employee WHERE $searchtype LIKE '$searchpart' ORDER BY role");
				
				echo "<table>";
				while($field = mysqli_fetch_field($result))
				{
					echo "<th>";
					echo $field->name . "<br>";
					echo "</th>\n";
				}
				
			echo "<th>Choice</th>";

			while($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
					echo "<td>";
					echo $row['employee_id'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['first_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['last_name'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['email_address'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['username'] . "<br>";
					echo "</td>\n";  
					
					echo "<td>";
					echo $row['role'] . "<br>";
					echo "</td>\n";  
				
					echo "<td>";
					echo 	"<form action='employeeUpdate.php' method='post'>
								<input type='hidden' name='id' value='" . $row['employee_id'] . "'>
								<input type='hidden' name='fname' value='" . $row['first_name'] . "'>
								<input type='hidden' name='lname' value='" . $row['last_name'] . "'>
								<input type='hidden' name='uname' value='" . $row['username'] . "'>
								<input type='hidden' name='email' value='" . $row['email_address'] . "'>
								<input type='hidden' name='role' value='" . $row['role'] . "'>
								<input type='submit' name='submit-edit' value='Update'>
							</form>";
					echo "</td>";
					
				echo "</tr>\n";
			}
			
			echo "</table>";
			
			echo "<button class='btn btn-primary btn-sm cancel' style='margin-left: 0px;' id='search-update-show'>Close search table</button>";
			mysqli_close($conn);
			echo "</div>";
		}
	}
?>
